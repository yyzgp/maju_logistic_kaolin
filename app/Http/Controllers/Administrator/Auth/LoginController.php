<?php

namespace App\Http\Controllers\Administrator\Auth;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:administrator')->except('logout');
    }

    public function showLoginForm()
    {
        return view('administrator.auth.login');
    }

    public function login(Request $request)
    {
        // Validate form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Attempt to log the user in
        if(Auth::guard('administrator')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember))
        {
            return redirect()->intended(route('administrator.dashboard'));

        }else{

           return $this->sendFailedLoginResponse($request);
       }

   }

   /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {

        if(Auth::guard('administrator')->check()) // this means that the admin was logged in.
        {
            Auth::guard('administrator')->logout();
            return redirect()->route('administrator.login');
        }
    }
}
