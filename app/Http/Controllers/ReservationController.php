<?php

namespace App\Http\Controllers;

use App\Reservation as Reservation;
use App\Room as Room;
use App\User as User;
use App\Setting as Setting;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Http\Request;
use DateTime;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Mail;
use DatePeriod;
use DateInterval;



class ReservationController extends Controller
{
	
	// Pantalla de calendario para usuario 'musician'
	public function make_reservation($room_id)
	{
		
		if($room_id != ''){
			$user               = Auth::user();
			$user_id            = $user->id;
			$bands              = $user->bands;
			$settings           = Setting::all();
			$max_card           = $settings->where('slug','max_card')->first()->value;
			$max_oxxo           = $settings->where('slug','max_oxxo')->first()->value;
			$min_available_oxxo = $settings->where('slug','min_available_oxxo')->first()->value;
			$user_comission = $settings->where('slug','user_comission')->first()->value;
			$expiration_oxxo     = Setting::where('slug','expiration_oxxo')->first()->value;
			$room               = Room::find($room_id);
			$reservations       = Reservation::where('room_id',$room_id)->where('status','!=','cancelled')->get();


			if($room->status == 'active' and $room->companies->status=='active'){
				$now                = Date::now();
				$room->promotions = $room->promotions->where('valid_ends', '>=',  $now);
				foreach ($room->promotions as $promotion) {
						
						$finishs = new Date($promotion->valid_ends);

						$finishs =  $finishs->format('l j F Y');
						


						if($promotion->rule == 'hours'){
							$rule = " de descuento en la reserva de al menos ".$promotion->hours.' horas';
						}elseif ($promotion->rule == 'schedule') {
							$days_array = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
							$days_valid = '';
							$days = explode(',',$promotion->days);
							foreach ($days as $key => $value) {

								
								if ($key === end($days)){
									$days_valid .= $days_array[$value];
								}else{
									$days_valid .= $days_array[$value].', ';
								}
							}

							$rules = ' en la reserva de tu ensayo entre las '.$promotion->schedule_starts.':00hrs. y las '.$promotion->schedule_ends.':00hrs. los días '.$days_valid;
						}

						if ($promotion->type == 'percentage'){
							$description = $promotion->value.'% de descuento'.$rules;
						}elseif ($promotion->type == 'hour_price'){
							$description = '$'.$promotion->value.' precio por hora '.$rules;
						}
						$description = $description." válida hasta el ".$finishs;
						$promotion->description = $description;
				}

				return view('reyapp.rooms.make_reservation')->with('room',$room)->with('bands',$bands)->with('reservations',$reservations)->with('user',$user)->with('max_oxxo',$max_oxxo)->with('max_card',$max_card)->with('min_available_oxxo',$min_available_oxxo)->with('user_comission',$user_comission)->with('expiration_oxxo',$expiration_oxxo); 
			}else{
				return redirect('/salas');
			}
			
		}else{
			return redirect('/salas');
		}
		
	}

	// AQUÍ REVISAMOS PRECIO EN PRIMERA INSTANCIA
	public function checkprice(Request $request)
	{
		$events     	= json_decode($request->events,true);
		$now        	= Date::now();
		$total      	= 0;
		$promotion_id 	= 0;
		$active  		= 0;

		$room       		= Room::find($request->room_id);
		$price 				= $room->price ;
		$promotions 		= $room->promotions->where('valid_ends', '>=', $now);
		$total_hours 		= $this->counting_hours($events);
		$promotion_totals 	= [];

		// Establecemos los valores y las reglas
		if($promotions->count()){
			
			$promotion_totals = [];
			
			foreach ($promotions as $promotion) {
				$total 			= 0;
				$promotion_id 	= $promotion->id;
				$type       	= $promotion->type;
				$discount   	= $promotion->value;
				$rule			= $promotion->rule;



				// STARTS:loop por hora
				foreach ($events as $event) {
					

					$starts     = $event['start'];
					$ends       = $event['end'];;
				   
					
					$begin  = new DateTime($starts);
					$end    = new DateTime($ends);

					$interval = new DateInterval('PT1H');
					$daterange = new DatePeriod($begin, $interval ,$end);

					foreach($daterange as $date){
						
						if($rule == 'schedule' ){
							$time = $date->format('H');
							$dayw = $date->format('w');
							$schedule_starts 	= $promotion->schedule_starts;
							$schedule_ends 		= $promotion->schedule_ends;
							$days				= explode(',',$promotion->days);
							
							//Si cumple las reglas schedule...
							if (in_array($dayw, $days) && $time >= $schedule_starts && $time < $schedule_ends){
								$active  	= 1;
								$unit_price = $this->discount($type,$discount,$price);
								$total 	+= $unit_price;
							
							//Si no las cumple...
							}else{
								$total 	+= $price;
							}				

						}elseif ($rule == 'hours') {
							if($total_hours >= $min_hours){
								$active  	= 1;
								$unit_price = $this->discount($type,$discount,$price);
								$total 	+= $unit_price;
							}else{
								$total 	+= $price;
							}
						}else{
							$total 	+= $price;
						}

						 
					}
				}//ENDS: loop por hora

				$promotion_totals[] = array( 'promotion_id'=>$promotion_id, 'total' =>$total, 'active' => $active) ;
			} //ENDS: loop Promotion
			
			

		}else{
			$total = $total_hours * $price;
		}

		
		return response()->json(['success' => true,'total'=>$total, 'promotion_totals' => $promotion_totals,'total_hours'=>$total_hours]);
		
		
	}

	private function discount($type,$discount,$price){
			if($type == 'percentage'){
				$percentage = $price * ($discount / 100);
				$cost = $price - $percentage;
			}elseif ($type == 'hour_price') {
				$cost = $discount;
			}

			return $cost;
	}


	private function counting_hours($events){
		$total_hours = 0;
		foreach ($events as $event) {
			$starts     = $event['start'];
			$ends       = $event['end'];;
		   
			
			$begin  = new DateTime($starts);
			$end    = new DateTime($ends);

			$interval = new DateInterval('PT1H');
			$daterange = new DatePeriod($begin, $interval ,$end);

			$total_hours +=  iterator_count($daterange);
		}

		return $total_hours;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$reservations = Reservation::orderBy('created_at');
		// Agregar la parte de buscar
		// if(request()->has('buscar')){
		//    $users->where('name', 'LIKE', '%' . request()->buscar . '%')->orWhere('email', 'LIKE', '%' . request()->buscar . '%');
		// }

		$reservations = $reservations->paginate(15);

		return view('reyapp.admin.reservations')->with('reservations',$reservations);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * AQUÍ, SE GUARDAN LAS RESERVACIONES DEL ADMINISTRADOR DE COMPAÑÍA LAS DEL USUARIO SE GUARDAN DESDE EL PAYMENTCONTROLLER
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{  

		// Registramos las reglas de validación
		$rules = array(
			'name'          => 'required|max:255',
			'room_id'       => 'required|integer',
			'start'         => 'required|date', 
			'end'           => 'required|date',
			'email'         => 'sometimes|nullable|email',       
		);

		// Validamos todos los campos
		$validator = Validator::make($request->all(), $rules);

		// Si la validación falla, nos detenemos y mandamos false
		if ($validator->fails()) {
			return response()->json(['success' => false,'message'=>'Hay campos con información inválida, recuerda que todos los campos son obligatorios']);
		}

		$user_id        = Auth::user()->id;
		$description    = $request->name." ".$request->email." ".$request->phone;
		$room_id        = $request->room_id;
		$starts         = $request->start;
		$ends           = $request->end;

		// Revisamos que la sala abra ese día, si no, detenemos y mandamos error
		$room = Room::findOrFail($room_id);
		$dow  = explode(',',$room->days);
		$check_dow = new Carbon($starts);
		$dow_names = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
		
		if(!in_array($check_dow->dayOfWeek, $dow)){
		   return response()->json(['success' => false,'message'=> 'La sala '.$room->name.' está cerrada en '.$dow_names[$check_dow->dayOfWeek]]); 
		};


		$starts_check = new Carbon($starts);
		$ends_check   = new Carbon($ends);

		$starts_time = $starts_check->format('H:i:s');
		$ends_time   = $ends_check->format('H:i:s');

		$open_time   = Carbon::createFromFormat('H', $room->schedule_start)->format('H:i:s');
		$close_time  = Carbon::createFromFormat('H', $room->schedule_end)->format('H:i:s');

		if($starts_time < $open_time){
			return response()->json(['success' => false,'message'=> 'La sala '.$room->name.' abre a las '.$open_time]); 
		}

		if($close_time < $ends_time){
			return response()->json(['success' => false,'message'=> 'La sala '.$room->name.' cierra a las '.$close_time]); 
		}

		$starts_check = $starts_check->modify('+1 minutes');
		$ends_check   = $ends_check->modify('-1 minutes');

		// Revisamos que la reservación no se empalme con otra
		$reservations_check = Reservation::where(
			function ($query) use ($starts_check) {
				$query->where('starts', '<',$starts_check)
				->where('ends', '>',$starts_check)->where('status','!=','cancelled');
			})->orWhere(function ($query) use ($ends_check) {
				$query->where('starts', '<',$ends_check)
				->where('ends', '>',$ends_check)->where('status','!=','cancelled');
			 })->orWhere(function ($query) use ($starts_check,$ends_check) {
				$query->where('starts', '>',$starts_check)
				->where('ends', '<',$ends_check)->where('status','!=','cancelled');
			})->get();

		// Si se empalmó revisamos que no sea en la misma sala
		$reservations_check = $reservations_check->where('room_id',$room_id);

		// Si no existe otra reservación en ese horario y esa misma sala lo guardamos
		if($reservations_check->isEmpty()){

			$reservation              = new Reservation();
			$reservation->description = $description;
			$reservation->starts      = $starts;
			$reservation->ends        = $ends;
			$reservation->user_id     = $user_id;

			$reservation->status      = 'confirmed';
			$reservation->is_admin    = true;
			
		
			$prefix = substr($room->companies()->first()->name, 0, 4);
			$prefix = str_replace(' ', '', $prefix);
			$random = str_random(8);

			$code   = strtoupper($prefix.$random);

			$reservation->code = $code;

			$room->reservations()->save($reservation);

			if ($request->has('band')) {
				$band = Band::find($request->band);
				$reservation->attach($band);
			}

			if($room->company_address){
				$room['address']        = $room->companies->address;
				$room['colony']         = $room->companies->colony;
				$room['deputation']     = $room->companies->deputation;
				$room['postal_code']    = $room->companies->postal_code;
				$room['latitude']       = $room->companies->latitude;
				$room['longitude']      = $room->companies->longitude;
				$room['city']           = $room->companies->city;
			}

			$room_name      = $room->name;
			$instructions   = $room->instructions;
			$date           = new Date($starts);;
			$date           = $date->format('l j F Y ');
			$starts         = new Date($starts);
			$ends           = new Date($ends);
			$starts         = $starts->format('H:i');
			$ends           = $ends->format('H:i');
			$email          = $request->email;
			$latitude       = $room->latitude;
			$longitude      = $room->longitude;
			$address        = $room->address.', '.$room->colony.', '.$room->deputation.', '.$room->city;
			$company        = $room->companies->name;

			if($request->has('email')){
				Mail::send('reyapp.mails.reminder', ['room_name'=>$room_name,'starts'=>$starts,'ends'=>$ends,'date'=>$date,'latitude'=>$latitude,'longitude'=>$longitude,'address'=>$address,'company'=>$company,'instructions'=>$instructions], function ($message)use($email,$company){

				$message->from('no_replay@ensayopro.com.mx', 'EnsayoPro')->subject('Tienes una reservación en '.$company);
				$message->to($email);

				});  
			}
			

			return response()->json(['success' => true , 'title' => $description,'id'=>$reservation->id,'color'=>$room->color]);
			

		}else{
			// Si si se empalma mandamos mensaje de error
			return response()->json(['success' => false , 'message' => 'Ese horario no está disponible en esa sala']);
		}
		
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($code)
	{
		
			$user = Auth::user();
			$user_id = $user->id;
			$reservation = Reservation::where('code',$code)->first();
			if($reservation->updated){
				redirect('/musico/agenda');
			}
			$room_id = $reservation->room_id;
			$room = Room::find($room_id);
			$reservation = $room->reservations->where('code',$code)->first();
		  
			return view('reyapp.rooms.edit_reservation')->with('room',$room)->with('user',$user)->with('code',$code)->with('reservation',$reservation);
			
		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $code)
	{
		$user_id     = Auth::user()->id;
		$reservation = Reservation::where('code',$code)->first();
		$room_id    = $reservation->rooms->id;

		$starts_check = new Carbon($request->starts);
		$ends_check   = new Carbon($request->ends);
	   
		if($user_id == $reservation->user_id){
			if($reservation->updated != true){


				$starts_check = $starts_check->modify('+1 minutes');
				$ends_check   = $ends_check->modify('-1 minutes');

				// Revisamos que la reservación no se empalme con otra
				$reservations_check = Reservation::where(
					function ($query) use ($starts_check) {
						$query->where('starts', '<',$starts_check)
						->where('ends', '>',$starts_check)->where('status','!=','cancelled');
					})->orWhere(function ($query) use ($ends_check) {
						$query->where('starts', '<',$ends_check)
						->where('ends', '>',$ends_check)->where('status','!=','cancelled');
					 })->orWhere(function ($query) use ($starts_check,$ends_check) {
						$query->where('starts', '>',$starts_check)
						->where('ends', '<',$ends_check)->where('status','!=','cancelled');
				})->get();

				// Si se empalmó revisamos que no sea en la misma sala
				$reservations_check = $reservations_check->where('room_id',$room_id);

				// Si no existe otra reservación en ese horario y esa misma sala lo guardamos
				if($reservations_check->isEmpty()){
					$reservation->starts     = new Date ($request->starts);
					$reservation->ends       = new Date ($request->ends);
					$reservation->updated    = true;
					$reservation->save();
					return response()->json(['success' => true]); 
				}else{
					return response()->json(['success' => true,'message'=>'Ese horario no está disponible']);
				}   


				
			}else{
				return response()->json(['success' => false, 'message' => 'Solo puedes reagendar cada reservación una vez']);
			}
		}else{
			return response()->json(['success' => false, 'message' => 'No tienes privilegios para cambiar esta reservación']);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	
	public function destroy($id)
	{   
		$user_id = Auth::user()->id;
		$reservation = Reservation::find($id);
		if($user_id == $reservation->user_id);{
			$reservation->delete();
		}
		return response()->json(['success' => true]);
	}

	public function cancel($id)
	{   
		$user_id = Auth::user()->id;
		$reservation = Reservation::find($id);
		if($user_id == $reservation->user_id);{
			$reservation->status = 'cancelled';
			$reservation->save();
			return response()->json(['success' => true]);
		}
		
	}

	public function prueba(){

		$reservations = Reservation::where('starts', '>=', Date::today())->whereHas('payments', function ($query) {
				$query->where('status','pending_payment')->where('expires_at', '<=', strtotime(Date::today()));
		})->get();

		foreach ($reservations as $reservation) {   
			$reservation->status = "cancelled";
			$reservation->save();     
		}
		
		return $reservations;
	}
}
