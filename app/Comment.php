<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{

	use SoftDeletes;

	protected $dates = ['deleted_at'];

    public function rooms()
    {
        return $this->belongsTo('App\Room','room_id');
    }

    public function users()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
