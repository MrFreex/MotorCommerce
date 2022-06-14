<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getAvatar($username) {
        $user = User::where('username', $username)->first();
        $avatar = $user->avatar;
        if (str_contains($avatar, 'http')) {
            return ($avatar);
        }

        return Storage::url($avatar);
    }
}
