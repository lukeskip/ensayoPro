<?php

namespace App\Http\Controllers;

use App\Role as Role;
use App\Company as Company;
use App\Room as Room;
use App\Reservation as Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\User as User;

class AdminCompanyController extends Controller
{
     public function company(){
    	$user_id = Auth::user()->id;
    	$user = User::find($user_id);
    	$company = $user->companies()->first();

      $room_ids  = [];

      foreach ($company->rooms as $room) {
        $room_ids[] = $room->id;
      }

      $reservations = Reservation::whereIn('room_id', $room_ids)->with(['users','rooms'])->get();

    	return view('reyapp.dashboard.dashboard_company')->with('user',$user)->with('company',$company)->with('reservations',$reservations);
    }

    public function company_calendar(){
    	$user_id = Auth::user()->id;
    	$user = User::find($user_id);
  		$company = $user->companies()->first();
  		$rooms = $company->rooms()->with('reservations')->get();
  		$room_ids  = [];
      foreach ($company->rooms as $room) {
        $room_ids[] = $room->id;
      }

  		$company_reservations = Reservation::whereIn('room_id', $room_ids)->with(['users','rooms'])->where('is_admin',true)->get();

  		$app_reservations = Reservation::whereIn('room_id', $room_ids)->with(['users','rooms'])->where('is_admin','!=',true)->get();
 
    	return view('reyapp.dashboard.company_calendar')->with('rooms',$rooms)->with('company_reservations',$company_reservations)->with('app_reservations',$app_reservations);

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
            $sumORatings = count($room->ratings);

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
