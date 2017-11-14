<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','lastname','email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function save (array $options = []){
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
        return $this->hasMany('App\Reservation');
    }

    public function ratings(){
        return $this->hasMany('App\Rating');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function rooms()
    {
        return $this->hasManyThrough('App\Room', 'App\Company');
    }


}
