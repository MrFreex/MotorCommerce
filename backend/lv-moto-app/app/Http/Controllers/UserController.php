<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUser($username) {
        $myuser = User::get($username);
        echo "Username: $myuser->username<br>Nome: $myuser->name<br>Email: $myuser->email<br>";
    }
}
