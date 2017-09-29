<?php

namespace App\Http\Controllers;

use App\Role as Role;
use App\Company as Company;
use App\Room as Room;
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
    // 	$user_id = Auth::user()->id;
    // 	$user = User::find($user_id);
  		// $company = $user->companies()->first();
  		// $rooms = $company->rooms()->get();
    	// return view('reyapp.dashboard.company_calendar')->with('rooms',$rooms);
    	return view('reyapp.dashboard.prueba');

    }

    public function admin(){
    	return 'Admin';
    }
}
