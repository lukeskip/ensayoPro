<?php

namespace App\Services;
use App\SocialFacebookAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;
use App\Role;

class SocialFacebookAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialFacebookAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialFacebookAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                $fullname = explode(' ',$providerUser->getName());

                $user = User::create([
                    'email'     => $providerUser->getEmail(),
                    'name'      => $fullname[0],
                    'lastname'  => $fullname[1],
                    'active'    => true,
                    'password'  => md5(rand(1,10000)),
                ]);

                $user->roles()->attach(Role::where('name','musician')->first()->id);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}