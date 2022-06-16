<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{

    private static function userUpload(Request $request, $dbfield, $storage)
    {
        $request->validate([
            'bg' => 'required_without:file|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'required_without:bg|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        $background = $request->bg;

        if(is_null($background)) {
            $request->file('file')->storeAs($storage, $user->username);
            $background = $user->username;
        }

        $user->update(array($dbfield => $background));

        return redirect("/userProfile/$user->username")->with('success', 'Upload successful.');
    }

    public function uploadAvatar(Request $request) {
        return UploadController::userUpload($request, 'avatar', 'avatars');
    }

    public function uploadBg(Request $request)
    {
        return UploadController::userUpload($request, 'userBg', 'backgrounds');
    }
}
