<?php

namespace App\Http\Controllers\Administrator\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use App\Models\Administrator;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function changePasswordForm()
    {
        $id = Auth::guard('administrator')->id();
        $user = Administrator::find($id);
        return view('administrator.settings.change-password', compact('user'));
    }

    public function changePassword(Request $request)
    {
        $id = Auth::guard('administrator')->id();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',

        ]);

        $user = Administrator::find($id);
      

        if (Hash::check($request->get('current_password'), $user->password)) {

            $user->password = Hash::make($request->new_password);

            $user->save();

            return redirect()->route('administrator.password.form')->with('success', 'Password changed successfully!');

        } else {

            return redirect()->back()->with('error', 'Current password is incorrect');
        }

        return redirect()->route('administrator.password.form')->with('success', 'Password changed successfully');
    }

}
