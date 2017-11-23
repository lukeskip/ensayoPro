<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function reservations(){
    	return $this->hasMany('App\Reservation');
    }

    public function companies(){
    	return $this->belongsTo('App\Company','company_id');;
    }

    public function rooms(){
    	return $this->belongsTo('App\Room','room_id');;
    }
}
