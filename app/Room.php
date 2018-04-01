<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

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

    public function promotions()
    {
        return $this->belongsToMany('App\Promotion','room_promotion');
    }

    public function types(){
        return $this->belongsTo('App\Type','type_id');;
    }
}
