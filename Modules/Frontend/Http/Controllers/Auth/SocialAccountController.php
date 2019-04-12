<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Models\User;
use Modules\Core\Models\Customer;
use Modules\Frontend\Services\LocalStorageService;
use Modules\Frontend\Services\PackageService;
use Socialite;


class SocialAccountController extends Controller
{
    protected $localStorageService;
    protected $packageService;
    public function __construct(LocalStorageService $localStorageService, PackageService $packageService)
    {
        $this->middleware('guest:customers');
        $this->localStorageService = $localStorageService;
        $this->packageService = $packageService;
    }
    public function redirectToProvider($provider)
    {
        session(['url_back' => url()->previous()]);
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $url = session('url_back', '/');
        session()->forget('url_back');
        try {
            $userSocial = Socialite::driver($provider)->user();
        } catch(\Exception $e) {
            return redirect($url);
        }
        // find in database if not create
        $user = Customer::where('provider_name', $provider)
                   ->where('provider_id', $userSocial->getId())
                   ->first();
        if (!$user) {
            // check user have email of account
            $user = Customer::where('email', $userSocial->getEmail())->first();

            if (! $user) {
                // if no have then create
                $user = Customer::create([
                    'email' => $userSocial->getEmail(),
                    'username' => $userSocial->getName(),
                    'provider_id'   => $userSocial->getId(),
                    'provider_name' => $provider,
                ]);
            } else {
                return redirect($url);
            }
        }
        auth()->guard('customers')->login($user, true);

        return redirect($url);
    }
}
