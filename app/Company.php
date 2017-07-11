<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function rooms()
    {
        return $this->hasMany('App\Room');
    }
}
