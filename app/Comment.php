<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function rooms()
    {
        return $this->belongsTo('App\Room','room_id');
    }

    public function users()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
