<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view("login");
    }

    public function validateLoginForm(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $creds = array('username' => $request->email, 'password' => $request->password);

        if (Auth::attempt($creds)) {
            return redirect()->route('/');
        }

        return LoginController::showLoginForm();
    }
}
