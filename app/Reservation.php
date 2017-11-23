<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
	use SoftDeletes;

	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function users(){
    	return $this->belongsTo('App\User','user_id');
    }

    public function rooms(){
    	return $this->belongsTo('App\Room','room_id');
    }

    public function payments(){
        return $this->belongsTo('App\Room','room_id');
    }

    public function bands()
    {
        return $this->belongsToMany('App\Band','band_reservation');
    }
}
