<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User','company_user');
    }

    public function rooms()
    {
        return $this->hasMany('App\Room');
    }
    
    public function media_items()
    {
        return $this->hasMany('App\MediaItem');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }
}
