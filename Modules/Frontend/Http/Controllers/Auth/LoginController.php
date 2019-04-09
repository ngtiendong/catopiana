<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Frontend\Services\LocalStorageService;
use Modules\Frontend\Services\PackageService;

class LoginController extends Controller
{
    protected $localStorageService;
    protected $packageService;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LocalStorageService $localStorageService, PackageService $packageService)
    {
        $this->middleware('guest:customers')->except('logout','updateDataTesting');
        $this->localStorageService = $localStorageService;
        $this->packageService = $packageService;
    }

    public function logout(Request $request)
    {
        if($request->input('local_storage') != '' || $request->input('local_storage') != null)
        {
            $this->localStorageService->updateTesting($request->input('local_storage'));
        }
        $this->guard()->logout();
        return response()->json([
            'status' => 200,
        ],200);    }


    public function login(Request $request)
    {
        $this->validateLogin($request);
        if ($this->attemptLogin($request)) {
            if(auth()->guard('customers')->user()->test_status == 0){
                $givePackage = $this->packageService->checkDoneFreeQuestion();
            }
            $local_storage = $this->localStorageService->getTesting();
            return response()->json([
                'status' => 200,
                'local_storage' => $local_storage,
                'givePackage' => $givePackage
            ],200);
        }
        return response()->json([
            'status' => 401
        ],200);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string|min:6',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return  $this->guard()->attempt($this->credentials($request));
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        // check login  email and username
        if(filter_var($request->username, FILTER_VALIDATE_EMAIL)){
            return ['email' => $request->username, 'password' => $request->password];
        }
        return $request->only($this->username(), 'password');
    }

    public function username()
    {
        return 'username';
    }

     /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('customers');
    }

    public function updateDataTesting(Request $request)
    {
        $customer_testing_id = '';
        if($request->input('local_storage_this_question') != '' || $request->input('local_storage_this_question') != null)
        {
            $customer_testing_id = $this->localStorageService->updateThisQuestion($request->input('local_storage_this_question'),$request->input('level'));
        }
        $givePackage = false;
        if(auth()->guard('customers')->user()->test_status == 0){
            $givePackage = $this->packageService->checkDoneFreeQuestion();
        }
        return response()->json([
            'status' => 200,
            'customer_testing_id' => $customer_testing_id,
            'givePackage' => $givePackage
        ],200);
    }
}
