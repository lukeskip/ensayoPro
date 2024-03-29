<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
  	private $user;
	private $jwtauth;
	
	public function __construct(User $user, JWTAuth $jwtauth)
	{
	  $this->user = $user;
	  $this->jwtauth = $jwtauth;
	}
	
	public function register(RegisterRequest $request)
	{
	
		$newUser = $this->user->create([
		  'name' => $request->get('name'),
		  'lastname' => $request->get('lastname'),
		  'email' => $request->get('email'),
		  'password' => bcrypt($request->get('password'))
		]);
		
		if (!$newUser) {
		  return response()->json(['failed_to_create_new_user'], 500);
		}
		//TODO: implement JWT
		// return response()->json(['user_created']);
		return response()->json(['token' => $this->jwtauth->fromUser($newUser)]);

	}

	public function login(LoginRequest $request)
	{
		// get user credentials: email, password
		$credentials = $request->only('email', 'password');
		
		$token = null;
		
		try {
			$token = $this->jwtauth->attempt($credentials);
			if (!$token) {
			  return response()->json(['invalid_email_or_password'], 422);
			}
		} catch (JWTAuthException $e) {
			return response()->json(['failed_to_create_token'], 500);
		}
		
		return response()->json(compact('token'));
	}

	public function logout(){
        Session::flush();
        Auth::guard($this->getGuard())->logout();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/login');
    }
}
