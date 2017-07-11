<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public function users(){
    	return $this->belongsToMany('App\User','company_user');
    }

    public function rooms(){
    	return $this->belongsTo('App\Room');
    }
}
