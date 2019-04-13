<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Models\User;
use Modules\Core\Models\Customer;
use Modules\Frontend\Events\SendEmailWhenGenerate;
// use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Modules\Frontend\Services\LocalStorageService;
use Modules\Frontend\Services\PackageService;

class RegistrationController extends Controller
{
    protected $localStorageService;
    protected $packageService;

    public function __construct(LocalStorageService $localStorageService, PackageService $packageService)
    {
        $this->middleware('guest:customers');
        $this->localStorageService = $localStorageService;
        $this->packageService = $packageService;
    }
    /*
    |--------------------------------------------------------------------------
    | Registration Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * show form registration.
     *
     * @return void
     */

    public function showRegistrationForm()
    {
        return view('frontend::registration');
    }

    /**
     * register.
     *
     * @return void
     */
    public function register(Request $request)
    {
        parse_str($request->data, $sign_up_data);
        $local_storage = $request->local_storage;
        $this->validator($sign_up_data)->validate();
        unset($sign_up_data['password_confirmation']);
        $user = $this->create($sign_up_data);
        if(!$user){
            return response()->json([
                'status' => 500,
                'errors' => 'server errors'
            ],500);
        }
        $this->guard()->login($user);
        $local_storage_response = [];
        $givePackage = false;
        if(!empty($local_storage))
        {
            $this->localStorageService->createTesting($local_storage);
            if(auth()->guard('customers')->user()->test_status == 0){
                $givePackage = $this->packageService->checkDoneFreeQuestion();
                $local_storage_response = $this->localStorageService->getTesting();
            }
        }
        return response()->json([
                'status' => 200,
                'success' => 'registed',
                'local_storage' => $local_storage_response,
                'givePackage' => $givePackage
            ],200);

        // return redirect()->route('home');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255','unique:customers'],
            'email' => ['required', 'string', 'email', 'max:255','unique:customers'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return Customer::create($data);
    }

    public function generateAccountEmail(Request $request)
    {
        $this->validatorEmail($request->all())->validate();
        $data_account = [
            'email' => $request->email,
            'username' => 'ctpa'.str_random(4),
            'password' => str_random(8)
        ];
        $customer = $this->create($data_account);
        // email customer name password for customer
        event(new SendEmailWhenGenerate($data_account));
        //
        $this->guard()->login($customer);
        return response()->json([
            'status' => 200
        ]);
    }

    public function generateAccount(Request $request)
    {   
        $this->validatorName($request->except('local_storage'))->validate();
        $data_account = [
            'username' => preg_replace('/\s+/', '' ,$request->input('username')) .'-' . str_random(6),  //substr((string) Str::uuid(), 0, 5),
            'password' => '123456'  //str_random(8)
        ];
        $customer = $this->create($data_account);
        if(!$customer){
            return response()->json([
                'status' => 500,
                'errors' => 'Server Error'   
            ],500);
        }
        $this->guard()->login($customer);
        // tạo và trả về
        $local_storage = [];
        $givePackage = false;
        if(!empty($request->input('local_storage')))
        {
            $this->localStorageService->createTesting($request->input('local_storage'));
            $local_storage = $this->localStorageService->getTesting();
            $givePackage = $this->packageService->checkDoneFreeQuestion();
        }
        return response()->json([
            'status' => 200,
            'username' => $data_account['username'],
            'password' => $data_account['password'],
            'local_storage' => $local_storage,
            'givePackage' => $givePackage
        ]);
    }


    protected function validatorEmail(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255','unique:customers']
        ]);
    }


    protected function validatorName(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:50','unique:customers']
        ]);
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

}
