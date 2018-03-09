<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\Room as Room;
use App\User as User;
use App\Type as Type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Date\Date;
use DateTime;


class TypeController extends Controller
{
    public function index(){

    }

    public function create(){
    	
    }
    
    public function show(){
    	
    }

    public function edit(){
    	
    }

    public function update(){
    	
    }

    public function change_rooms_type(){
    	$rooms = Room::all();
    	$type_room = Type::where('name','room')->first();
    	foreach ($rooms as $room) {
    		$room->type_id = $type_room->id;
    		$room->save();
    		echo $room->types->name;
    	}
    }
}
