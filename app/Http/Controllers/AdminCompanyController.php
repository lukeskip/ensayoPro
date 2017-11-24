<?php

namespace App\Http\Controllers;

use App\Role as Role;
use App\Company as Company;
use App\Room as Room;
use App\Payment as Payment;
use App\Reservation as Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\User as User;
use Jenssegers\Date\Date;

class AdminCompanyController extends Controller
{ 
	// Dashboard
	public function company(){
		$user_id 	= Auth::user()->id;
		$user 		= User::find($user_id);
		$company 	= $user->companies()->first();
		$hours  	= 0;
		$room_ids  	= [];
		
		if ($company !== null) {
			
			foreach ($company->rooms as $room) {
				$room_ids[] = $room->id;
			}

			// si tiene una companía revisamos los payments en su nombre [[Settings]]
			$day1 = Date::parse('last tuesday')->startOfDay();
	        $day2 = Date::parse('next monday')->endOfDay();

			$payments = Payment::where('company_id',$company->id)->whereBetween('created_at',[$day1,$day2])->where('status','paid')->get();

			$incomings = 0;

			//Sumamos los paymentes de la semana para obtener lo ingresos
			foreach ($payments as $payment) {
				$incomings += $payment->amount;
			}
		}

		$reservations = Reservation::whereIn('room_id', $room_ids)->whereBetween('created_at',[$day1,$day2])->with(['users','rooms','bands'])->get();

		foreach ($reservations as $reservation) {
			$date_starts = new Date($reservation['starts']);
			$date_ends = new Date($reservation['ends']);
			if($reservation->status == 'confirmed'){
				$reservation['hours'] = $date_starts->diffInHours($date_ends);
				$hours += $reservation->hours;
			}
			
			$reservation['date'] = $date_starts->format('d F h:i').' a '.$date_ends->format('h:i');
			$reservation['total'] = $reservation->payments->amount;

			
		}


		return view('reyapp.companies.dashboard')->with('user',$user)->with('company',$company)->with('reservations',$reservations)->with('incomings',$incomings)->with('hours',$hours);
	}



	public function company_calendar(){
		$user_id = Auth::user()->id;
		$user = User::find($user_id);
		$company = $user->companies()->first();
		$rooms = $company->rooms()->with('reservations')->where('status','active')->get();
		$room_ids  = [];
		foreach ($company->rooms as $room) {
			$room_ids[] = $room->id;
		}

		// Las reservaciones que generó el administrador de la sala
		$company_reservations = Reservation::whereIn('room_id', $room_ids)->with(['users','rooms'])->where('is_admin',true)->get();

		// Las reservaciones generadas a través de la plataforma
		$app_reservations = Reservation::whereIn('room_id', $room_ids)->with(['users','rooms','bands'])->where('is_admin','!=',true)->get();

		return view('reyapp.companies.calendar')->with('rooms',$rooms)->with('company_reservations',$company_reservations)->with('app_reservations',$app_reservations);

	}

	public function company_rooms (){
			$items_per_page = 10;
			$order = 'quality_up';
					
			$rooms = Room::paginate($items_per_page);

			// Si tienen la misma dirección de la compañía la asignamos y la mandamos dentro del mismo objeto
			foreach ($rooms as $room) {

					if($room->company_address){
							$room['address']        = $room->companies->address;
							$room['colony']         = $room->companies->colony;
							$room['deputation']     = $room->companies->deputation;
							$room['postal_code']    = $room->companies->postal_code;
							$room['latitude']       = $room->companies->latitude;
							$room['longitude']      = $room->companies->longitude;
					}
					
					// Cuantificamos y promediamos las calificaciones en base 5
					$quality = 0;
					$sumRatings = count($room->ratings);

					if($sumRatings > 0){
							foreach ($room->ratings as $rating) {
									$quality += $rating->score;
							}

							$quality = $quality / $sumRatings;
							$room['score']    = round(($quality *100) / 5);
					}
					
					$room['ratings'] = $sumRatings;
			}
			
			$companies = Company::orderBy('name', 'desc')->get();
			$order = request()->order;

			return view('reyapp.companies.list_rooms')->with('rooms',$rooms)->with('companies',$companies)->with('order',$order);
	}
}
