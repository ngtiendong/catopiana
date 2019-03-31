<?php

namespace Modules\Frontend\Services;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function findOrCreate(ProviderUser $providerUser, $provider)
    {
        // check account exist
        $account = SocialAccount::where('provider_name', $provider)
                   ->where('provider_id', $providerUser->getId())
                   ->first();

        if ($account) {
            // return if have account
            return $account->user;
        } else {
            // check user have email of account
        $user = User::where('email', $providerUser->getEmail())->first();

        if (! $user) {
            // if no have then create
            $user = User::create([  
                'email' => $providerUser->getEmail(),
                'name'  => $providerUser->getName()
            ]);
        }

        // update infor
        
        
        // create account
        $user->accounts()->create([
            'provider_id'   => $providerUser->getId(),
            'provider_name' => $provider
        ]);

        return $user;

        }
    }
}