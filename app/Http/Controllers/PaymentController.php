<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation as Reservation;
use App\Room as Room;
use App\User as User;
use App\Payment as Payment;
use App\Setting as Setting;
use Illuminate\Support\Facades\Auth as Auth;
use Carbon\Carbon;
use Mail;
use Jenssegers\Date\Date;


class PaymentController extends Controller
{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		//Constructor
		public function __construct()
		{
				\Conekta\Conekta::setApiKey(env('CONEKTA_SECRET_KEY'));
				\Conekta\Conekta::setApiVersion("2.0.0");
		}

		//Creando un pago mediante tarjeta
		public function CreatePayCard(Request $request)
		{
				$user        = Auth::user();
				$user_id     = $user->id;
				$room_id     = $request->room_id;
				$room        = Room::find($room_id);
				$events      = json_decode($request->events,true);
				$total_h     = 0;
				$ids         = array();
				$band_id	 = 0;
				$max_card 	 = Setting::where('slug','max_card')->first()->value;

				if(count($events) < 1){
					return response()->json(['success' => false,'message'=> 'Tienes que seleccionar un horario']);
				}
				
				for($i=0;$i<count($events);$i++){
					
						$description  = $events[$i]['title'];
						$starts_check = new Carbon($events[$i]['start']);
        				$ends_check   = new Carbon($events[$i]['end']);

        				$starts_check = $starts_check->modify('+1 minutes');
        				$ends_check   = $ends_check->modify('-1 minutes');

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

						// Si no existe otra reservación en ese horario y esa misma sala ponemos el status en available
						if($reservations_check->isEmpty()){
								$prefix = substr($room->companies()->first()->name, 0, 4);
								$prefix = str_replace(' ', '', $prefix);
								$random = str_random(8);
								$code   = strtoupper($prefix.$random);

								$months = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
								
								$events[$i]['code']         = $code; 
								$events[$i]['status']       = 'available';
								$start                      = new Carbon($events[$i]['start']);
								$end                        = new Carbon($events[$i]['end']);
								$events[$i]['day']          = $start->format('d');
								$events[$i]['month']        = $months[$start->format('m')-1];
								$events[$i]['start_time']   = $start->format('H:i');
								$events[$i]['end_time']     = $end->format('H:i');

							
								 
								$reservation              = new Reservation();
								$reservation->description = $description;
								$reservation->starts      = $start;
								$reservation->ends        = $end;
								$reservation->user_id     = $user_id;
								
								// Si el request incluye una banda se agrega si no se deja en blanco
								if(array_key_exists('band', $events[$i])) {
    								$band_id = $events[$i]['band'];
    								$reservation->band_id  = $band_id;
								}
								

								$reservation->status      = 'pending';
								$reservation->is_admin    = false;
						
								$prefix = substr($room->companies()->first()->name, 0, 4);
								$prefix = str_replace(' ', '', $prefix);
								$random = str_random(8);

								$code   = strtoupper($prefix.$random);

								$reservation->code = $code;

								$room->reservations()->save($reservation);
							 
								$total_h += $start->diffInHours($end);     
								$ids []   =  $reservation->id;

						}else{
								return response()->json(['success' => false,'message'=> 'Alguien más tomó uno de tus horarios']);
						}
				}


				if($total_h > $max_card){
					Reservation::whereIn('id', $ids)->update(['status' => 'cancelled']);
					return response()->json(['success' => false,'message'=>'Con esta forma de pago solo puedes reservar hasta '.$max_card.' horas']); 
				}
				$price = $total_h * $room->price;

				$valid_order =
				array(
						'line_items'=> array(
								array(
										'name'        => $room->name,
										'description' => 'Renta de instalaciones',
										'unit_price'  => $room->price * 100,//El costo se pasa en centavos
										'quantity'    => $total_h
								)
						),
						'currency'    => 'MXN',
					//'metadata'    => array('test' => 'extra info'),
						'charges'     => array(
							array(
									'payment_method' => array(
											'type'       => 'card',
											'token_id' => $request->input('token')
									)
									 //'amount' => $precio
							)
					),
						'currency'      => 'MXN',
						'customer_info' => array(
								'name'  => $request->input('name'),
								'phone' => $request->input('phone'),
								'email' => $request->input('email')
						)
				);

				try {
						$order = \Conekta\Order::create($valid_order);

						$pI = $order['id'];
						$pM = $order->charges[0]->payment_method->type;
						$pR = 0;
						$pS = $order['payment_status'];
						$pA = $order->amount;
						$pQ = $order->line_items[0]->quantity;
						// $rsp = array("id"=>$pI,"method"=>$pM,"reference"=>$pR,"status"=>$pS,'price'=>$price);

						$payment         		= new Payment;
						$payment->code   		= $pI;
						$payment->amount 		= $pA/100;
						$payment->method 		= $pM;
						$payment->company_id 	= $room->companies->id;
						$payment->room_id 		= $room->id;
						$payment->quantity		= $pQ;
						$payment->status		= $pS;
						$payment->save();

						Reservation::whereIn('id', $ids)->update(['status' => 'confirmed','payment_id'=>$payment->id]);
						
						return response()->json(['success' => true,'message'=>$pS,'code'=>$payment->code]);

					 
						
					} catch (\Conekta\ProcessingError $e){ 
						Reservation::whereIn('id', $ids)->update(['status' => 'cancelled']);
						
						$message = json_decode($e->errorStack);
						$message = $message->details[0]->message;

						return response()->json(['success' => false,'message' => $message]);
						 
						
					} catch (\Conekta\ParameterValidationError $e){

						Reservation::whereIn('id', $ids)->update(['status' => 'cancelled']);
						
						// return response()->json(['success' => false,'message'=>$e->details->message]);
				} 
				catch (\Conekta\Handler $e){
						Reservation::whereIn('id', $ids)->update(['status' => 'cancelled']);
						// return response()->json(['success' => false,'message'=>$e->details->message]);


				}

		}

		//Creando un pago mediante Oxxo.
		public function CreatePayOxxo(Request $request)
		{

				$user        = Auth::user();
				$user_id     = $user->id;
				$room_id     = $request->room_id;
				$room        = Room::find($room_id);
				$events      = json_decode($request->events,true);
				$total_h     = 0;
				$ids         = array();
				$max_oxxo 	 = Setting::where('slug','max_oxxo')->first()->value;
				$min_available_oxxo 	 = Setting::where('slug','min_available_oxxo')->first()->value;

				if(count($events) < 1){
					return response()->json(['success' => false,'message'=> 'Tienes que seleccionar un horario']);
				}
				
				for($i=0;$i<count($events);$i++){
					$now 			= Date::now();
					$starts_check 	= new Date($events[$i]['start']);
					$diff = $now->diffInHours($starts_check);
					if($diff < $min_available_oxxo){
						return response()->json(['success' => false,'message'=> 'No puedes utilizar este método de pago con menos de  '.$min_available_oxxo.' horas antes de tu ensayo']);
					
					}
				}
				
				for($i=0;$i<count($events);$i++){
					
						$description  		= $events[$i]['title'];
						$starts_check 		= new Carbon($events[$i]['start']);
        				$ends_check   		= new Carbon($events[$i]['end']);
        				$reserv_insert  	= array();	

        				$starts_check = $starts_check->modify('+1 minutes');
        				$ends_check   = $ends_check->modify('-1 minutes');

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

						// Si no existe otra reservación en ese horario y esa misma sala ponemos el status en available
						if($reservations_check->isEmpty()){
								$prefix = substr($room->companies()->first()->name, 0, 4);
								$prefix = str_replace(' ', '', $prefix);
								$random = str_random(8);
								$code   = strtoupper($prefix.$random);

								$months = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
								
								$events[$i]['code']         = $code; 
								$events[$i]['status']       = 'available';
								$start                      = new Carbon($events[$i]['start']);
								$end                        = new Carbon($events[$i]['end']);
								$events[$i]['day']          = $start->format('d');
								$events[$i]['month']        = $months[$start->format('m')-1];
								$events[$i]['start_time']   = $start->format('H:i');
								$events[$i]['end_time']     = $end->format('H:i');
							
								 
								$reservation              = new Reservation();
								$reservation->description = $description;
								$reservation->starts      = $start;
								$reservation->ends        = $end;
								$reservation->user_id     = $user_id;
								
								// Si el request incluye una banda se agrega si no se deja en blanco
								if(array_key_exists('band', $events[$i])) {
    								$band_id = $events[$i]['band'];
    								$reservation->band_id  = $band_id;
								}

								$reservation->status      = 'pending';
								$reservation->is_admin    = false;
						
								$prefix = substr($room->companies()->first()->name, 0, 4);
								$prefix = str_replace(' ', '', $prefix);
								$random = str_random(8);

								$code   = strtoupper($prefix.$random);

								$reservation->code = $code;

								$room->reservations()->save($reservation);
							 
								$total_h += $start->diffInHours($end);     
								$ids []   =  $reservation->id;

						}else{
								return response()->json(['success' => false,'message'=> 'Alguien más tomó uno de tus horarios']);
						}
				}

				

				if($total_h > $max_oxxo){
					Reservation::whereIn('id', $ids)->update(['status' => 'cancelled']);
					return response()->json(['success' => false,'message'=>'Con esta forma de pago solo puedes reservar hasta '.$max_oxxo.' horas']); 
				}
				
				$price = $total_h * $room->price;

				$expire = strtotime(date("Y-m-d H:i:s")) + "36000";
				$valid_order =
				array(
						'line_items'=> array(
							array(
								'name'        => $room->name,
								'description' => 'Renta de instalaciones',
								'unit_price'  => $room->price * 100,//El costo se pasa en centavos
								'quantity'    => $total_h
							)
				),
				'currency'      => 'MXN',
					// 'metadata'    => array('test' => 'extra info'),
				'charges'     => array(
					array(
							'payment_method' => array(
									'type'       => 'oxxo_cash',
									'expires_at' => $expire
							)
									 //'amount' => $precio
					)
				),
				'currency'      => 'MXN',
				'customer_info' => array(
						'name'  => $request->input('name'),
						'phone' => $request->input('phone'),
						'email' => $request->input('email')
				)
		);

		try {
			$order = \Conekta\Order::create($valid_order);
					$pI = $order['id'];
					$pM = $order->charges[0]->payment_method->type;
					$pR = $order->charges[0]->payment_method->reference;
					$pS = $order['payment_status'];

					$rsp = array("id"=>$pI,"method"=>$pM,"reference"=>$pR,"status"=>$pS);
				//INFORMACIÓN IMPORTANTE DEL JSON DE RESPUESTA.
				// ID: $order->id
				// Método de pago: $order->charges[0]->payment_method->service_name
				// Referencia: $order->charges[0]->payment_method->reference
				// Total: $order->amount/100 . $order->currency (lo manda en centavos, por eso se divide entre 100)
				// Orden:
				// Cantidad:  $order->line_items[0]->quantity
				// Nombre: $order->line_items[0]->name
				// Precio unitario $order->line_items[0]->unit_price/100

				$pI = $order['id'];
				$pM = $order->charges[0]->payment_method->type;
				$pS = $order['payment_status'];
				$pA = $order->amount;
				$pQ = $order->line_items[0]->quantity;
				$pE = $order->charges[0]->payment_method->expires_at;
				// $rsp = array("id"=>$pI,"method"=>$pM,"reference"=>$pR,"status"=>$pS,'price'=>$price);

				$payment         		= new Payment;
				$payment->code   		= $pI;
				$payment->amount 		= $pA/100;
				$payment->method 		= $pM;
				$payment->company_id 	= $room->companies->id;
				$payment->room_id 		= $room->id;
				$payment->quantity		= $pQ;
				$payment->status		= $pS;
				$payment->reference  	= $pR;
				$payment->expires_at 	= $pE;
				$payment->save();

				Reservation::whereIn('id', $ids)->update(['payment_id'=>$payment->id]);
				
				return response()->json(['success' => true,'message'=>$pS,'code'=>$payment->code]);

			} catch (\Conekta\ProcessingError $e){ 
				return $this->Response(0,$e);
		} catch (\Conekta\ParameterValidationError $e){
				return $this->Response(0,$e);
		} 
		catch (\Conekta\Handler $e){
				return $this->Response(0,$e);
		}

		}

		public function confirmation(){
			// $body = @file_get_contents('php://input');
			// $data = json_decode($body);
			// http_response_code(200); // Return 200 OK
			$status = '$data->type';
			Mail::send('reyapp.mail_test', ['status'=>$status], function ($message)use($status){

				$message->from('no_replay@ensayopro.com.mx', 'EnsayoPro')->subject('Eres parte de');
				$message->to('contacto@reydecibel.com.mx');

				});
			} 
			// if ($data->type == 'charge.paid'){
			//   Mail::send('reyapp.mail_test', ['status'=>$status], function ($message)use($status){

			// 	$message->from('no_replay@ensayopro.com.mx', 'EnsayoPro')->subject('Eres parte de');
			// 	$message->to('contacto@reydecibel.com.mx');

			// 	});
			// } 
		}

		//Manejo de respuestas
		private function Response($success,$result)
		{
				if($success==0){ $result=$result->getMessage(); } 
				$out = array("type"=>$success,"data"=>$result);
				return view('reyapp.testResponse')->with('response',$out); 
		}

	

		public function index()
		{
				return view ('reyapp.payments.index');
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
		 *
		 * @param  \Illuminate\Http\Request  $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
				//
		}

		/**
		 * Display the specified resource.
		 *
		 * @param  int  $id
		 * @return \Illuminate\Http\Response
		 */
		public function show($code)
		{
				$payment = Payment::where('code',$code)->with('reservations')->get()->first();
 				foreach ($payment->reservations as $reservation) {
 					$starts 				  		= new Date ($reservation->starts);
 					$starts_display 	  		= $starts->format('H:i');
 					$ends 				  		= new Date($reservation->ends);
 					$ends_display 		  		= $ends->format('H:i');
 					$reservation['starts'] 	= $starts_display;
 					$reservation['ends'] 	= $ends_display;
 					$reservation['month'] 	= $starts->format('F');
               		$reservation['day'] 		= $starts->format('d');
 				}
 				


 				return view('reyapp.payments.single')->with('payment',$payment);
		}

		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param  int  $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id)
		{
				//
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request  $request
		 * @param  int  $id
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, $id)
		{
				//
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int  $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id)
		{
				//
		}
}
