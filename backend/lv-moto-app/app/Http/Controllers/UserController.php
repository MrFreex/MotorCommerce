<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SettingsRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public static function getAsset($avatar, $type = 'avatars') {
        if (str_contains($avatar, 'http')) {
            return ($avatar);
        }

        return Storage::url($type . '/' . $avatar) . $avatar;
    }

    public static function showSettings() {
        $user = Auth::user();
        if (!$user) {
            return redirect()->back();
        }

        return view('user.settings', [
            'user' => $user,
            'avatar' => self::getAsset($user->avatar),
            'bg' => self::getAsset($user->bg),
            'availableSettings' => $user->getSettings()
        ]);
    }

    public static function applySettings(SettingsRequest $request) {
        $user = Auth::user();

        if (!$user) {
            return redirect()->back();
        }

        if ($request->validated()) {
            if ($user->applySettings($request->all())) {
                return redirect()->back()->with('success', 'Settings applied successfully!');
            }
        }
    }

    public static function changePassword(Request $request) {
        $user = Auth::user();

        if (!$user) {
            return redirect()->back();
        }

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        ]);

        $user->setPasswordAttribute($request->password);
        
        return redirect()->back()->with('success', 'Password changed successfully!');
    }
}
