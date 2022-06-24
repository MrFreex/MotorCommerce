<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}

class UserProfileController extends Controller
{
    public function show($username, $usePopup = false) {
        $user = User::where('displayname', $username)->first();
        if (!$user) {
            return redirect()->back();
        }
        return view('userProfile', ['username' => $username, 'userdata' => array( 
            'avatar' => $user->avatar,
            'profileBg' => $user->profileBg,
            'name' => $user->name,
            'birthday' => $user->birthday
         )])->with("usePopup", $usePopup);
    }
}
