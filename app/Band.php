<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User','band_user');
    }

    public function reservations()
    {
        return $this->belongsToMany('App\Reservation','band_reservation');
    }

    public function events(){
        return $this->hasMany('App\Event');
    }
}
