<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public function users()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
