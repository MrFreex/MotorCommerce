<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}

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
        console_log($creds);
        console_log(Auth::attempt($creds));
        if (Auth::attempt($creds)) {
            return redirect('/');
        }

        return LoginController::showLoginForm();
    }

    public function logout() {
        Session::flush();
        Auth::logout();

        return redirect('/');
    }
}
