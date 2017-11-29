<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','phone','lastname','email', 'password'
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

        if(empty($this->active_token)){
            $active_token =  str_random(60);
            $email        = $this->email;
            $this->active_token = $active_token;
            
            if(!empty($this->name)){
                Mail::send('reyapp.mails.welcome', ['token'=>$active_token,'email'=>$email], function ($message)use($email){

                    $message->from('no_replay@ensayopro.com.mx', 'EnsayoPro')->subject('Bienvenido a EnsayoPro');
                    $message->to($email);

                });   
            }
            
        }

        

        if(empty($this->active)){
            $this->active = false;
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
        return $this->belongsToMany('App\Band','band_user');
    }

    public function settings(){
        return $this->hasMany('App\Setting');
    }

    public function reservations(){
        return $this->hasMany('App\Reservation');
    }

    public function events(){
        return $this->hasMany('App\Event');
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

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }


}
