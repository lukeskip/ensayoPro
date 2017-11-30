<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User','band_user');
    }

    public function reservations(){
        return $this->hasMany('App\Reservation');
    }

    public function events(){
        return $this->hasMany('App\Event');
    }
}
