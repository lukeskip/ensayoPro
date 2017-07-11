<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function companies()
    {
        return $this->belongsTo('App\Company')->withTimestamps();
    }

    public function reservations()
    {
        return $this->hasMany('App\Reservation');
    }
}
