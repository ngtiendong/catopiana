<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Models\User;
use Socialite;


class SocialAccountController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $userSocial = Socialite::driver($provider)->user();
        // try{
        //     $userSocial = Socialite::driver($provider)->user();
        // } catch(\Exception $e) {
        //     return redirect()->back();
        // }
        // find in database if not create
        // 
        // 
        $user = User::where('provider_name', $provider)
                   ->where('provider_id', $userSocial->getId())
                   ->first();

        if (!$user) {
            // check user have email of account
            $user = User::where('email', $userSocial->getEmail())->first();

            if (! $user) {
                // if no have then create
                $user = User::create([  
                    'email' => $userSocial->getEmail(),
                    'username' => $userSocial->getName(),
                    'provider_id'   => $userSocial->getId(),
                    'provider_name' => $provider,
                ]);
            } else {
                return back()->with(['errors' =>'Email has been already']);
            }
        }

        auth()->login($user, true);

        return redirect('/');
    }
}
