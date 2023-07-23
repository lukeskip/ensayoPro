<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/registro/redirect';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            // 'g-recaptcha-response' => 'required|captcha'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user =  User::create([
            'name' => $data['name'],
            'lastname'=>$data['lastname'],
            'phone'=>$data['phone'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        if(array_key_exists('role',$data)){
            $role = Role::where('token',$data['role'])->first();
            $user->roles()->attach($role->id);
        }else{
            $user->roles()->attach(Role::where('name', 'musician')->first());
        }

        $email = $data['email'];
        $fname = $data['name'];
        $lname = $data['lastname'];
        $debug = isset($_POST["debug"])?$_POST["debug"]:0;
        $apikey = 'e943f205e43e7e2b323ecb0df36738b5-us13';
        $listid = '40842ca585';
        $server = 'us13.';
        $auth = base64_encode( 'user:'.$apikey );
        $data = array(
            'apikey'        => $apikey,
            'email_address' => $email,
            'status'        => 'subscribed',
            'merge_fields'  => array(
                'FNAME' => $fname,
                'LNAME' => $lname,
                'TYPE' => $user->roles()->first()->name,
                )
        );
        $json_data = json_encode($data);
        
        if($fname!='' and $lname!='' and $email!=''){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://'.$server.'api.mailchimp.com/3.0/lists/'.$listid.'/members/');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                'Authorization: Basic '.$auth));
            curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            $result = curl_exec($ch);
        }

        

        return $user;
    }
}
