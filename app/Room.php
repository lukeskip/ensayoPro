<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function companies()
    {
        return $this->belongsTo('App\Company','company_id');
    }

    public function reservations()
    {
        return $this->hasMany('App\Reservation');
    }

    public function media_items()
    {
        return $this->hasMany('App\MediaItem');
    }

    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    public function offers()
    {
        return $this->hasMany('App\Offer');
    }
}
