<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function companies(){
        return $this->belongsTo('App\Company','company_id');
    }
}
