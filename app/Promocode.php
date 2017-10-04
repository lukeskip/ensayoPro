<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    protected $fillable = [
		'code',
		'reward',
		'quantity',
  		'is_used',
	];
}
