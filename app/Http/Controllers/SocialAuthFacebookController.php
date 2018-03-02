<?php

// SocialAuthFacebookController.php

namespace App\Http\Controllers;

use Socialite;
use App\Services\SocialFacebookAccountService;
use Session;
use Request;
use URL;

class SocialAuthFacebookController extends Controller
{
  /**
   * Create a redirect method to facebook api.
   *
   * @return void
   */
    public function redirect()
    { 
        session(['goto' => URL::previous()]);  
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
        return redirect()->to();
    }
}