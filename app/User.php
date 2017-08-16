<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function save(array $options = []){
        if(empty($this->api_token)){
            $this->api_token = str_random(60);
        }

        return parent::save($options);
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function companies()
    {
        return $this->belongsToMany('App\Company');
    }

    public function bands()
    {
        return $this->belongsToMany('App\Band');
    }

    public function reservations(){
        return $this->belongsToMany('App\Reservation');
    }
}
