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

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customers');
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

        $this->validator($request->all())->validate();
        $user = $this->create($request->except('_token'));
        $this->guard()->login($user);

        return redirect()->route('home');
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
            'password' => ['required', 'string', 'min:6'],
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

    public function generateAccount(Request $request)
    {
        $this->validatorEmail($request->all())->validate();
        $data_account = [
            'email' => $request->email,
            'username' => 'ctpa'.str_random(4),
            'password' => str_random(8)
        ];
        $user = $this->create($data_account);
        // email user name password for user
        event(new SendEmailWhenGenerate($data_account));
        //
        $this->guard()->login($user);
        return response()->json([
            'status' => 200
        ]);
    }


    protected function validatorEmail(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255','unique:customers']
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