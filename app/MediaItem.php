<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaItem extends Model
{
    public function rooms()
    {
        return $this->belongsTo('App\Room');
    }

    public function companies()
    {
        return $this->belongsTo('App\Companies');
    }
}
