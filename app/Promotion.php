<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    public function rooms(){
    	return $this->belongsToMany('App\Room','room_promotion');
    }

    public function companies(){
    	return $this->belongsTo('App\Company','company_id');
    }
}
