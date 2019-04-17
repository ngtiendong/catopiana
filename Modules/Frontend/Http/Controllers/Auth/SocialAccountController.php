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
            session()->forget('local_storage');
            return redirect($url);
            // show message here error server
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
                session()->forget('local_storage');
                return redirect($url);
                // email social này đã đăng kí tài khoản
            }
            auth()->guard('customers')->login($user, true);
            // user mới thì thêm dữ liệu vào db
            $local_storage = session('local_storage');

            if(!empty($local_storage))
            {
                $this->localStorageService->createTesting($local_storage);
            }
        } else {
            auth()->guard('customers')->login($user, true);
        }
        
        $local_storage_response = [];
        $local_storage = session('local_storage');
        $local_storage_response = $this->localStorageService->getTesting();
        session(['local_storage_response' => $local_storage_response]);
        session()->forget('local_storage');
        return redirect($url);
    }

    public function sendLocalStorageSocial(Request $request)
    {
        session(['local_storage' => $request->input('local_storage')]);
        return response()->json([
            'status' => 200,
        ]);
    }
}
