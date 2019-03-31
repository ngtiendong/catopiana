<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Socialite;
use Modules\Frontend\Services\SocialAccountService;

class SocialAccountController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(SocialAccountService $accountService, $provider)
    {

        try{
            // get user from social
            $user = Socialite::driver($provider)->user();
        } catch(\Exception $e) {
            return redirect()->back();
        }
        // find in database if not create
        $authUser = $accountService->findOrCreate(
            $user,
            $provider
        );

        auth()->login($authUser, true);

        return redirect()->route('home');
    }
}
