<?php

namespace App\Http\Controllers;

use App\Promotion;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Http\Request;
use App\User as User;
use App\Room as Room;
use App\Setting as Setting;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Date\Date;
use DateTime;

class PromotionController extends Controller
{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
				$user = Auth::user();

				if(!Auth::guest()){
						$user_id = $user->id;
						$role = User::find($user_id)->roles->first()->name;  
				}

				
				$companies = $user->companies()->with('promotions')->paginate();
				
				$promotions = $companies->promotions;
				
				foreach ($promotions as $promotion) {
						$now                = Date::now();
						$finishs            = new DateTime($promotion->valid_ends);
						$finishs            = $ends->diffInDays($now);
						$promotion['ends']  = $finishs;
				}

				return view('reyapp.companies.promotions')->with('promotions',$promotions);
		}

		public function index_company()
		{
				$user = Auth::user();
				$now  = Date::now();

				if(!Auth::guest()){
						$user_id = $user->id;
						$role = $user->roles->first()->name;
						$company = $user->companies->first();

				}




				if($company){
					$company_id = $company->id;
				}else{
					return redirect('/company');
				}

	 
				$promotions = Promotion::where('company_id',$company_id)->where('valid_ends','>=',$now)->orderby('valid_ends','DESC')->paginate();
				

				foreach ($promotions as $promotion) {
						
						$finishs            = new Date($promotion->valid_ends);
						if($now <= $finishs){
							$finishs            = $finishs->diffInDays($now);
							$promotion['finishs']  = 'Le quedan '.$finishs.' día(s)';  
						}else{
							$edit = true;
							$promotion['finishs']  = 'Esta promoción caducó';   
						}


						if($promotion->rule == 'hours'){
							$rules = " de descuento en la reserva de al menos ".$promotion->hours.' horas';
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

						if($promotion->type == 'direct'){
							$description = '$'.$promotion->value.' de descuento '.$rules;
						}elseif ($promotion->type == 'percentage'){
							$description = $promotion->value.'% de descuento'.$rules;
						}elseif ($promotion->type == 'hour_price'){
							$description = '$'.$promotion->value.' precio por hora '.$rules;
						}
						
						$promotion->description = $description;

						if($promotion->status != 'published'){
							$promotion['edit'] = true;
						}
				}
				
				return view('reyapp.companies.promotions')->with('promotions',$promotions)->with('company',$company)->with('now',$now);
		}

		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create()
		{
				$user = Auth::user();

				if(!Auth::guest()){
						$company = $user->companies->first();  
				}
				$settings               = Setting::all();
				$max_prom_percentage    = $settings->where('slug','max_prom_percentage')->first()->value;
				$max_prom_direct        = $settings->where('slug','max_prom_direct')->first()->value;

				$min_hour_price        = $settings->where('slug','min_hour_price')->first()->value;

				

				$rooms      = $company->rooms;    
				return view('reyapp.promotions.register')->with('rooms',$rooms)->with('max_prom_direct',$max_prom_direct)->with('max_prom_percentage',$max_prom_percentage)->with('min_hour_price',$min_hour_price);
		}

		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request  $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
				// Registramos las reglas de validación
				$rules = array(
						'name'              => 'required|max:255',
						'status'            => 'required',
						'type'              => 'required|in:direct,percentage,hour_price',
						'rooms'             => 'required',
						'discount'          => 'required|integer',
						'valid_starts'      => 'required|date', 
						'valid_ends'        => 'required|date',
						'rule'              => 'required|in:schedule,hours',        
						'starts'            => 'date', 
						'min_hours'         => 'nullable|integer',        
				);

				$user    	= Auth::user();
				$company 	= $user->companies->first(); 
				$status  	= $request->status;
				$type    	= $request->type;
				$value   	= $request->discount;
				$settings 	= Setting::all();
				$min_hour_price_discount = $settings->where('slug','min_hour_price_discount')->first()->value;

				// Validamos todos los campos
				$validator = Validator::make($request->all(), $rules);


				// Si la validación falla, nos detenemos y mandamos false
				if ($validator->fails()) {
						return response()->json([$validator->messages(),'success'=>false], 200);
				}

				$promotion = new Promotion;
				$promotion->name            = $request->name;
				$promotion->status          = $status;
				$promotion->type            = $type;
				$promotion->company_id      = $company->id;
				$promotion->valid_starts    = $request->valid_starts;
				$promotion->valid_ends      = $request->valid_ends;
				$promotion->value           = $value;
				$promotion->rule            = $request->rule;
				$promotion->min_hours       = $request->min_hours;



				// Si el valor es -1 agregamos todas las salas del usuario
				if(in_array('-1',$request->rooms)){
						$rooms_ids = [];
						$rooms = Room::where('company_id',$company->id)->get();
				}else{
						$rooms  = Room::whereIn('id', $request->rooms)->get();
				}

				if($type == 'direct'){
						$value = '$'.$value;
				}elseif ($type == 'percentage') {
						$value = $value.'%';
				}elseif($type = 'hour_price'){
					foreach ($rooms as $room) {
						$price 	= $room->price;
						$diff 	= $price - $value;
						if($diff < $min_hour_price_discount){
							return response()->json(['success' => false,'message'=>'El descuento debe de ser de al menos $'.$min_hour_price_discount.' pesos tomando en cuenta cada una de las salas participantes']);
						}
					}
				}

				if($request->rule == 'hours'){

						$promotion->hours  = $request->hours;

				}else if($request->rule == 'schedule'){
						// Si el valor es -1 agregamos todos los días al string
						
						if(in_array('-1',$request->days)){
								$days    = '0,1,2,3,4,5,6';
						}else{
								$days    = implode(',', $request->days);
						}
						$promotion->days  = $days;

						$promotion->schedule_starts  = $request->schedule_starts;
						$promotion->schedule_ends    = $request->schedule_ends;
				}
				

				
				$promotion->save();

				foreach ($rooms as $room) {
						$promotion->rooms()->attach($room->id,['pivot_valid_ends' => $promotion->valid_ends,'pivot_status'=>$promotion->status]);
				}

				

				return response()->json(['success' => true,'message'=>'Se guardó correctamente']);


		}

		/**
		 * Display the specified resource.
		 *
		 * @param  \App\Offer  $offer
		 * @return \Illuminate\Http\Response
		 */
		public function show($id)
		{
				//
		}

		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param  \App\Offer  $offer
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id)
		{	
				$user      = Auth::user();
				$company   = $user->companies->first();
				$promotion = Promotion::find($id);
				$settings               = Setting::all();
				$max_prom_percentage    = $settings->where('slug','max_prom_percentage')->first()->value;
				$max_prom_direct        = $settings->where('slug','max_prom_direct')->first()->value;

				$min_hour_price        = $settings->where('slug','min_hour_price')->first()->value;

				if($promotion->status == 'draft' and $promotion->company_id == $company->id){
					$rooms      = $company->rooms;
					$promotion['days'] = explode(',',$promotion->days);

					$valid_starts = new Date($promotion->valid_starts);
					$promotion->valid_starts = $valid_starts->format('Y-m-d');

					$valid_ends = new Date($promotion->valid_ends);
					$promotion->valid_ends = $valid_ends->format('Y-m-d');

					$rooms_array = [];

					foreach ($promotion->rooms as $room) {
						$rooms_array[]= $room->id;
					}

					return view('reyapp.promotions.edit')->with('rooms',$rooms)->with('max_prom_direct',$max_prom_direct)->with('max_prom_percentage',$max_prom_percentage)->with('min_hour_price',$min_hour_price)->with('promotion',$promotion)->with('rooms_array',$rooms_array);
				}else{
					redirect('/companies/promotions');
				}
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request  $request
		 * @param  \App\Offer  $offer
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, $id)
		{
				// Registramos las reglas de validación
				$rules = array(
						'name'              => 'required|max:255',
						'status'            => 'required',
						'type'              => 'required|in:direct,percentage,hour_price',
						'rooms'             => 'required',
						'discount'          => 'required|integer',
						'valid_starts'      => 'required|date', 
						'valid_ends'        => 'required|date',
						'rule'              => 'required|in:schedule,hours',        
						'starts'            => 'date', 
						'min_hours'         => 'nullable|integer',        
				);

				$user    	= Auth::user();
				$company 	= $user->companies->first(); 
				$status  	= $request->status;
				$type    	= $request->type;
				$value   	= $request->discount;
				$settings 	= Setting::all();
				$min_hour_price_discount = $settings->where('slug','min_hour_price_discount')->first()->value;



				// Validamos todos los campos
				$validator = Validator::make($request->all(), $rules);


				// Si la validación falla, nos detenemos y mandamos false
				if ($validator->fails()) {
						return response()->json([$validator->messages(),'success'=>false], 200);
				}

				$promotion = Promotion::find($id);

				if($user->companies()->first()->id != $promotion->companies->id){
					return response()->json(['success' => false,'message'=>'No tienes los permisos para editar esta promoción']);
				}

				$promotion->name            = $request->name;
				$promotion->status          = $status;
				$promotion->type            = $type;
				$promotion->company_id      = $company->id;
				$promotion->valid_starts    = $request->valid_starts;
				$promotion->valid_ends      = $request->valid_ends;
				$promotion->value           = $value;
				$promotion->rule            = $request->rule;
				$promotion->min_hours       = $request->min_hours;



				// Si el valor es -1 agregamos todas las salas del usuario
				if(in_array('-1',$request->rooms)){
						$rooms_ids = [];
						$rooms = Room::where('company_id',$company->id)->get();
				}else{
						$rooms  = Room::whereIn('id', $request->rooms)->get();
				}

				if($type == 'direct'){
						$value = '$'.$value;
				}elseif ($type == 'percentage') {
						$value = $value.'%';
				}elseif($type = 'hour_price'){
					foreach ($rooms as $room) {
						$price 	= $room->price;
						$diff 	= $price - $value;
						if($diff < $min_hour_price_discount){
							return response()->json(['success' => false,'message'=>'El descuento debe de ser de al menos $'.$min_hour_price_discount.' pesos tomando en cuenta cada una de las salas participantes']);
						}
					}
				}

				if($request->rule == 'hours'){

						$promotion->hours  = $request->hours;

				}else if($request->rule == 'schedule'){
						// Si el valor es -1 agregamos todos los días al string
						
						if(in_array('-1',$request->days)){
								$days    = '0,1,2,3,4,5,6';
						}else{
								$days    = implode(',', $request->days);
						}
						$promotion->days  = $days;

						$promotion->schedule_starts  = $request->schedule_starts;
						$promotion->schedule_ends    = $request->schedule_ends;
				}
				

				
				$promotion->save();
				$rooms_array = [];
				foreach ($rooms as $room) {
						$rooms_array []= $room->id; 

				}

				$promotion->rooms()->sync($rooms_array,['pivot_valid_ends' => $promotion->valid_ends,'pivot_status'=>$promotion->status]);

				

				return response()->json(['success' => true,'message'=>'Se guardó correctamente']);
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  \App\Offer  $offer
		 * @return \Illuminate\Http\Response
		 */
		public function destroy(Offer $id)
		{
				//
		}
}
