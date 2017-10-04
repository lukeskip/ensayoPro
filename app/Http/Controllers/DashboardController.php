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

  

    public function admin(){
    	return 'Admin';
    }
}
