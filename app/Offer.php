<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public function rooms(){
    	return $this->belongsTo('App\Room','room_id');
    }

    public function companies(){
    	return $this->belongsTo('App\Company','company_id');
    }
}
