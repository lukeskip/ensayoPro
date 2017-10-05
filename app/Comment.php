<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function rooms()
    {
        return $this->belogsTo('App\Room','room_id');
    }

    public function users()
    {
        return $this->belogsTo('App\User','user_id');
    }
}
