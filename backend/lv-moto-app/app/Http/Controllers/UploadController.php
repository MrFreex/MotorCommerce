<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function uploadBg(Request $request)
    {
        $request->validate([
            'bg' => 'required_without:file|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'required_without:bg|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        $background = $request->bg;

        if(is_null($background)) {
            $request->file('file')->storeAs('avatars', $user->username);
            $background = $user->username;
        }

        $user->update(array('profileBg' => $background));
        
        echo "Background successfully updated.";
        echo $background;
    }
}
