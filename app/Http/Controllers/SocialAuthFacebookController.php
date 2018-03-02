<?php

// SocialAuthFacebookController.php

namespace App\Http\Controllers;

use Socialite;
use App\Services\SocialFacebookAccountService;
use Session;
use Request;

class SocialAuthFacebookController extends Controller
{
  /**
   * Create a redirect method to facebook api.
   *
   * @return void
   */
    public function redirect()
    {
        Session::put('url.intended', Request::fullUrl());  
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback(SocialFacebookAccountService $service)
    {
        
        $user = $service->createOrGetUser(Socialite::driver('facebook')->stateless()->user());
        auth()->login($user);
        return redirect()->intended();
    }
}