<?php

namespace App\Http\Controllers;

use App\Role as Role;
use App\Company as Company;
use App\Room as Room;
use App\Reservation as Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\User as User;

class DashboardController extends Controller
{
    public function musician(){
    	return 'musician';
    }

    public function company(){
    	$user_id = Auth::user()->id;
    	$user = User::find($user_id);
    	$company = $user->companies()->first();
    	return view('reyapp.dashboard.dashboard_company')->with('user',$user)->with('company',$company);
    }

    public function company_calendar(){
    	$user_id = Auth::user()->id;
    	$user = User::find($user_id);
  		$company = $user->companies()->first();
  		$rooms = $company->rooms()->with('reservations')->get();
  		
  		$company_reservations = Reservation::with(['users','rooms'])->where('user_id',$user_id)->get();

  		$app_reservations = Reservation::with(['users','rooms'])->where('user_id','!=',$user_id)->get();
 
    	return view('reyapp.dashboard.company_calendar')->with('rooms',$rooms)->with('company_reservations',$company_reservations)->with('app_reservations',$app_reservations);

    }

    public function admin(){
    	return 'Admin';
    }
}
