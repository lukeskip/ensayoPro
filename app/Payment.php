<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function reservations(){
    	return $this->belongsTo('App\Reservation','reservation_id');
    }
}
