<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation as Reservation;
use App\Room as Room;
use App\User as User;
use App\Payment as Payment;
use App\Setting as Setting;
use App\Band as Band;
use DateTime;
use DatePeriod;
use DateInterval;
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
				$email		 = $user->email;
				$user_id     = $user->id;
				$room_id     = $request->room_id;
				$room        = Room::find($room_id);
				$events      = json_decode($request->events,true);
				$total_h     = 0;
				$ids         = array();
				$band_id	 = 0;
				$max_card 	 = Setting::where('slug','max_card')->first()->value;
				$user_comission = Setting::where('slug','user_comission')->first()->value;

				if(count($events) < 1){
					return response()->json(['success' => false,'message'=> 'Tienes que seleccionar un horario']);
				}


				
				for($i=0;$i<count($events);$i++){
					
						$description  = $events[$i]['title'];
						$starts_check = new Carbon($events[$i]['start']);
        				$ends_check   = new Carbon($events[$i]['end']);

        				// formateamos el inicio y fin del ensayo para envio de correo
        				$mail_starts  = new Date($events[$i]['start']);
        				$mail_ends    = new Date($events[$i]['end']);

        				$events[$i]['mail_time'] = $mail_starts->format('H:i').' a '.$mail_ends->format('H:i');

        				$events[$i]['mail_date'] = $mail_starts->format('l j F Y ');

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
								),
								array(
									'name'        => "Cargo por servicio",
									'description' => 'Cargo por servicio',
									'unit_price'  => $user_comission * 100,//El costo se pasa en centavos
									'quantity'    => 1
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
						$pS = $order['payment_status'];
						$pT = $order->amount / 100; //Total de la transacción
						$pQ = $order->line_items[1]->quantity;
						$pC = $order->line_items[0]->unit_price / 100;
						$pA = ($order->line_items[1]->unit_price * $order->line_items[1]->quantity) / 100;//cargo sin contar la comision
						// $rsp = array("id"=>$pI,"method"=>$pM,"reference"=>$pR,"status"=>$pS,'price'=>$price);

						$payment         		= new Payment;
						$payment->order_id   	= $pI;
						$payment->amount 		= $pA;
						$payment->total 		= $pT;
						$payment->method 		= $pM;
						$payment->company_id 	= $room->companies->id;
						$payment->room_id 		= $room->id;
						$payment->quantity		= $pQ;
						$payment->comission		= $pC;
						$payment->status		= $pS;
						$payment->save();

						// Extraemos las variables para el envío de correo
						 if($room->company_address){
			                $room['address']        = $room->companies->address;
			                $room['colony']         = $room->companies->colony;
			                $room['deputation']     = $room->companies->deputation;
			                $room['postal_code']    = $room->companies->postal_code;
			                $room['latitude']       = $room->companies->latitude;
			                $room['longitude']      = $room->companies->longitude;
			                $room['city']           = $room->companies->city;
            			}
						
						$room_name  	= $room->name;
						$latitude		= $room->latitude;
						$longitude		= $room->latitude;
						$instructions 	= $room->instructions;
						$company 		= $room->companies->name;
						$address        = $room->address.', '.$room->colony.', '.$room->deputation.', '.$room->city;
						


						// confirmamos el estatus de la reservación
						Reservation::whereIn('id', $ids)->update(['status' => 'confirmed','payment_id'=>$payment->id]);

				
						
						// Enviamos respuesta en formato JSON
						return response()->json(['success' => true,'message'=>$pS,'code'=>$payment->order_id]);

					 
						
					} catch (\Conekta\ProcessingError $e){ 
						Reservation::whereIn('id', $ids)->update(['status' => 'cancelled']);
						
						$message = json_decode($e->errorStack);
						$message = $message->details[0]->message;

						return response()->json(['success' => false,'message' => $message]);
						 
						
					} catch (\Conekta\ParameterValidationError $e){
						$message = json_decode($e->errorStack);
						$message = $message->details[0]->message;
						return response()->json(['success' => false,'message' => $message]);
						Reservation::whereIn('id', $ids)->update(['status' => 'cancelled']);
						
				} 
				catch (\Conekta\Handler $e){
						$message = json_decode($e->errorStack);
						$message = $message->details[0]->message;
						return response()->json(['success' => false,'message' => $message]);
						Reservation::whereIn('id', $ids)->update(['status' => 'cancelled']);


				}

		}

		//Creando un pago mediante https://www.facebook.com/NocheDeQuiz/videos/2162282630666059/?hc_ref=ARTCMGNwRCoNUmrswQn7U-yXD_ZfycEjUix3EzQQEmZle7ddc4ynWqQDmkcokscoZgcxo.
		public function CreatePayOxxo(Request $request)
		{	
			$max_oxxo 	 = Setting::where('slug','max_oxxo')->first()->value;
			$min_available_oxxo 	 = Setting::where('slug','min_available_oxxo')->first()->value;
			$user_comission 	 	= Setting::where('slug','user_comission')->first()->value;
			$expiration_oxxo 	 = Setting::where('slug','expiration_oxxo')->first()->value;

			$user        = Auth::user();
			$user_id     = $user->id;
			$room_id     = $request->room_id;
			$promotion_id = $request->promotion_id;
			$room        = Room::find($room_id);
			$events      = json_decode($request->events,true);
			$total_h     = 0;
			$ids         = array();
			$now         = Date::now();
			$expire 	 = strtotime($now->add($expiration_oxxo.' hours'));

			
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

				// formateamos el inicio y fin del ensayo para envio de correo
				$mail_starts  = new Date($events[$i]['start']);
				$mail_ends    = new Date($events[$i]['end']);

				$events[$i]['mail_time'] = $mail_starts->format('H:i').' a '.$mail_ends->format('H:i');

				$events[$i]['mail_date'] = $mail_starts->format('l j F Y ');

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
			 


			$valid_order =
				array(
					'line_items'=> array(
						array(
							'name'        => "Cargo por servicio",
							'description' => 'Cargo por servicio',
							'unit_price'  => $user_comission * 100,//El costo se pasa en centavos
							'quantity'    => 1,
							'metadata' => array(
								'type' => 'comission'
						)
					),	
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


			// STARTS: promotions**************************************
			
			
			$total_natural     	= 0;
			$total_promotions  	= 0;
			$active  			= 0;
			$price 				= $room->price ;
			$promotions 		= $room->promotions->where('id',$promotion_id)->where('valid_ends','>=',$now)->first();
			$total_hours 		= $this->counting_hours($events);
			$charges 			= [];
			$total_natural 			= 0;
			$total_promotions 		= 0;
			$total_hours_natural 	= 0;
			$total_hours_promotions = 0;

			// Establecemos los valores y las reglas
			if($promotions){
				$promotion_totals = [];
				$type       			= $promotions->type;
				$discount   			= $promotions->value;
				$rule					= $promotions->rule;


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
							$schedule_starts 	= $promotions->schedule_starts;
							$schedule_ends 		= $promotions->schedule_ends;
							$days				= explode(',',$promotions->days);
							
							//Si cumple las reglas schedule...
							if (in_array($dayw, $days) && $time >= $schedule_starts && $time < $schedule_ends){
								
								$active  	= 1;
								$unit_price = $this->discount($type,$discount,$price);
								$total_promotions = $unit_price;
								 $total_hours_promotions +=1;
								
							//Si no las cumple...
							}else{
								$total_natural = $price;
								$total_hours_natural += 1;
							}	
	

						}elseif ($rule == 'hours') {
							if($total_hours >= $min_hours){
								$active  	= 1;
								$unit_price = $this->discount($type,$discount,$price);
								$total_promotions = $unit_price;
								$total_hours_promotions +=1;
							}else{
								$total_natural = $price;
								$total_hours_natural += 1;
							}
						}else{
							$total_natural = $price;
							$total_hours_natural += 1;
						}

						 
					}
				}//ENDS: loop por hora

				// agregamos el cargo por las horas de promocion
				array_push($charges,array('title'=>'Horas reservadas con promoción','total'=> $total_promotions,'total_hours'=>$total_hours_promotions,'type'=>'promotion'));
				


			$pI = $order['id'];
			$pM = $order->charges[0]->payment_method->type;
			$pS = $order['payment_status'];
			$pT = $order->amount /100; //Total de la transacción
			$pQ = $order->line_items[1]->quantity;
			$pC = $order->line_items[0]->unit_price / 100;
			$pA = ($order->line_items[1]->unit_price * $order->line_items[1]->quantity) / 100;//cargo sin contar la comision
			$pE = $order->charges[0]->payment_method->expires_at;
			// $rsp = array("id"=>$pI,"method"=>$pM,"reference"=>$pR,"status"=>$pS,'price'=>$price);

			$payment         		= new Payment;
			$payment->order_id   	= $pI;
			$payment->amount 		= $pA;
			$payment->total 		= $pT;
			$payment->method 		= $pM;
			$payment->company_id 	= $room->companies->id;
			$payment->room_id 		= $room->id;
			$payment->quantity		= $pQ;
			$payment->comission		= $pC;
			$payment->status		= $pS;
			$payment->reference  	= $pR;
			$payment->expires_at 	= $pE;
			$payment->save();

			Reservation::whereIn('id', $ids)->update(['payment_id'=>$payment->id]);

			// Seteamos las variables para el envio de correo con la referencia
			$reference 	  = $payment->reference;
			$room_name    = $room->name;
			$company_name =	$room->companies()->first()->name;
			$user_mail 	  = $user->email;
			$amount 	  = $payment->amount + $payment->comission;



			}else{
				$total_natural = $price;
				$total_hours_natural = $total_hours;
			}

			// agregamos el cargo por las horas naturales si es que hay alguna
			if($total_natural > 0 AND $total_hours_natural > 0){
				
				array_push($charges,array('title'=> 'Horas reservadas sin promoción','total' => $total_natural,'total_hours' => $total_hours_natural,'type'=>'natural'));	
			}

			

			// Hacemos push al arrey de Items de conekta
			foreach ($charges as $charge) {
				array_push($valid_order['line_items'],array(
					'name'        => $charge['title'],
					'description' => 'Renta de instalaciones',
					'unit_price'  => $charge['total'] * 100,//El costo se pasa en centavos
					'quantity'    => $charge['total_hours'],
					'metadata' => array(
						'type' => $charge['type']
					)

				)); 

			}
			// ENDS: promotions*******************************


			try {
				$order = \Conekta\Order::create($valid_order);
				$pI = $order['id'];
				$pM = $order->charges[0]->payment_method->type;
				$pR = $order->charges[0]->payment_method->reference;
				$pS = $order['payment_status'];

				$rsp = array("id"=>$pI,"method"=>$pM,"reference"=>$pR,"status"=>$pS);
					

				$pI = $order['id'];
				$pM = $order->charges[0]->payment_method->type;
				$pS = $order['payment_status'];
				$pT = $order->amount /100; //Total de la transacción

				// Declaramos las variables que serán ocupadas en los costos
				$pQ    = 0;
				$pUP   = 0;
				$pC    = 0;
				$pQP   = 0;
				$pUPP  = 0;
				
				// asignamos la cantidad de horas y comision
				foreach ($order->line_items as $line) {
					
					$line_type = $line['metadata']['type'];
					
					if($line_type == 'comission' ){
						
						$pC = $line->unit_price / 100;

					}elseif ($line_type == 'natural') {
						
						$pQ  = $line->quantity;
						$pUP = $line->unit_price / 100;

					}elseif ($line_type == 'promotion') {
						
						$pQP  = $line->quantity;
						$pUPP = $line->unit_price / 100;

					}
					
				}

				$pA = (($pUP * $pQ)+($pUPP * $pQP));//cargo sin contar la comision
				
				$pE = $order->charges[0]->payment_method->expires_at;
				// $rsp = array("id"=>$pI,"method"=>$pM,"reference"=>$pR,"status"=>$pS,'price'=>$price);

				$payment         			= new Payment;
				$payment->order_id   		= $pI;
				$payment->amount 			= $pA;
				$payment->total 			= $pT;
				$payment->method 			= $pM;
				$payment->company_id 		= $room->companies->id;
				$payment->room_id 			= $room->id;
				$payment->quantity			= $pQ;
				$payment->unit_price		= $pUP;
				$payment->unit_price_prom	= $pUPP;
				$payment->quantity_prom		= $pQP;
				$payment->comission			= $pC;
				$payment->status			= $pS;
				$payment->reference  		= $pR;
				$payment->expires_at 		= $pE;
				$payment->save();

				Reservation::whereIn('id', $ids)->update(['payment_id'=>$payment->id]);
				
				return response()->json(['success' => true,'message'=>$pS,'code'=>$payment->order_id]);

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

			$body = @file_get_contents('php://input');
			$data = json_decode($body);
			http_response_code(200); // Return 200 OK 
	
			if ($data->type == 'charge.paid'){
				// $reference 	=  $data->data->object->payment_method->reference;
				$order_id 	=  $data->data->object->order_id;
				$status 	=  $data->data->object->status;
				$payment 	=  Payment::where('order_id',$order_id)->first();

				$room 		= $payment->reservations->first()->rooms;
				$emails  	= array();
				$user_email = $payment->reservations->first()->users->email;
				$payment->status = $status;
				$payment->save();

				$company_email = $payment->companies->users->first()->email;

				// Extraemos las variables para el envío de correo
				 if($room->company_address){
	                $room['address']        = $room->companies->address;
	                $room['colony']         = $room->companies->colony;
	                $room['deputation']     = $room->companies->deputation;
	                $room['postal_code']    = $room->companies->postal_code;
	                $room['latitude']       = $room->companies->latitude;
	                $room['longitude']      = $room->companies->longitude;
	                $room['city']           = $room->companies->city;
    			}

    			// Declaramos las variables para el envío de correo
				$company 		= $room->companies->name;
				$room_name  	= $room->name;
				$latitude		= $room->latitude;
				$longitude		= $room->latitude;
				$instructions 	= $room->instructions;
				$company 		= $room->companies->name;
				$address        = $room->address.', '.$room->colony.', '.$room->deputation.', '.$room->city;

				$reservations = $payment->reservations;

				foreach ($reservations as $reservation) {

					$reservation->status = 'confirmed';
					$reservation->save();

					$mail_starts  = new Date($reservation->starts);
	    			$mail_ends    = new Date($reservation->ends);
					$reservation->mail_time =  $mail_starts->format('H:i').' a '.$mail_ends->format('H:i');
	    			$reservation->mail_date = $mail_starts->format('l j F Y ');

				}

    			// Enviamos un correo a la compañía con la información de todas las reservaciones
				Mail::send('reyapp.mails.confirmation_com', ['room_name'=>$room_name,'reservations'=>$reservations,'company'=>$company,'instructions'=>$instructions], function ($message)use($company_email,$room_name){

                $message->from('no_replay@ensayopro.com.mx', 'EnsayoPro')->subject('Tienes una reservación en '.$room_name);
                $message->to($company_email);

                });

	        	// agrupamos las reservaciones por banda
				$reservations = $payment->reservations->groupBy('band_id');


				// Iteramos a partir de cada grupo (uno por banda) de reservaciones
				$reservations->each(function($group, $index)use($room,$user_email,$status) {

					// Declaramos las variables para el envío de correo
					$company 		= $room->companies->name;
					$room_name  	= $room->name;
					$latitude		= $room->latitude;
					$longitude		= $room->latitude;
					$instructions 	= $room->instructions;
					$company 		= $room->companies->name;
					$address        = $room->address.', '.$room->colony.', '.$room->deputation.', '.$room->city;

					foreach ($group as $reservation) {

						$reservation->status = 'confirmed';
						$reservation->save();

						$mail_starts  = new Date($reservation->starts);
		    			$mail_ends    = new Date($reservation->ends);
						$reservation->mail_time =  $mail_starts->format('H:i').' a '.$mail_ends->format('H:i');
		    			$reservation->mail_date = $mail_starts->format('l j F Y ');

					}

					// Determinamos la banda de la reservación
					if($group[0]->band_id){
						$band = Band::find($group[0]->band_id);
						foreach ($band->users as $user) {
							// Obtenemos los correos de los usuarios en esa banda
							$emails[] = $user->email;
						};
					}else{
						$emails = array($user_email);
					}

				    // Enviamos correo de confirmación para cada banda con todas las reservaciones que le corresponden a cada una
					Mail::send('reyapp.mails.confirmation', ['room_name'=>$room_name,'reservations'=>$group,'latitude'=>$latitude,'longitude'=>$longitude,'address'=>$address,'company'=>$company,'instructions'=>$instructions], function ($message)use($emails,$company){

	                $message->from('no_replay@ensayopro.com.mx', 'EnsayoPro')->subject('Tienes una reservación en '.$company);
	                $message->to($emails);

	                });

		
				});


			}		
			
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
			
			$payments = Payment::where('order_id', 'LIKE', '%' . request()->buscar . '%')->paginate();
			
			foreach ($payments as $payment) {
			
				$date = new Date($payment->updated_at);
				$date = $date->format('l j F Y H:i');
				$payment->date = $date;
			}

			$max = $payments->max('amount');
			return view ('reyapp.payments.list')->with('payments',$payments)->with('max',$max);
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
		public function show($order_id)
		{
				$payment = Payment::where('order_id',$order_id)->with('reservations')->get()->first();
 				foreach ($payment->reservations as $reservation) {
 					$starts 				  	= new Date ($reservation->starts);
 					$starts_display 	  		= $starts->format('H:i');
 					$ends 				  		= new Date($reservation->ends);
 					$ends_display 		  		= $ends->format('H:i');
 					$reservation['starts'] 		= $starts_display;
 					$reservation['ends'] 		= $ends_display;
 					$reservation['month'] 		= $starts->format('F');
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
}
