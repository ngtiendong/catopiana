<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Core\Http\Requests\LoginRequest;
use Modules\Core\Models\UserRole;
use Modules\Insurance\Models\InsuranceAdvisoryHistory;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

    }

    /**
     * Login page for admin
     */
    public function login()
    {
        return view('core::user.login');
    }

    /**
     * Process login
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function loginPost(LoginRequest $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
            $user = Auth::user();
            $role = UserRole::select('role_id')->where('user_id', $user->id)->first();
            Session::put('role_id', $role->role_id);
            return redirect(route('admin_home'));
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect(route('login'));
    }
}
