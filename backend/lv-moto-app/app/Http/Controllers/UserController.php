<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use App\Http\Requests\CreateUserRequest;
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

    public static function createView() {
        return view('admin.pages.user-create', [ 'availableSettings' => Auth::user()->getSettings()]);
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

    public function confirmCreate(CreateUserRequest $request) {
        $validated = $request->validated();
       // echo '<pre>'; print_r($request->validated()); echo '</pre>';
        if ($validated) {
            User::create($validated); 
        }

        return redirect()->route('admin.users.create')->with("success", "User created successfully!");
    }

    public function confirmEdit(Request $request) {

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return redirect()->route('admin.users')->with("error", "User not found!");
        }

        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email:rfc,dns', Rule::unique('users')->ignore($user->id) ],
            'username' => ['required', 'alpha_dash', Rule::unique('users')->ignore($user->id), 'min:3' ],
            'displayname' => ['required', 'alpha_dash', Rule::unique('users')->ignore($user->id), 'different:username', 'min:3' ],
            'phone' => 'numeric|nullable',
            'birthday' => 'date|required|before:-16 years',
            'zip' => 'numeric|nullable',
        ]);

        $to_update = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'displayname' => $request->displayname,
            'birthday' => $request->birthday,
            'zip' => $request->zip,
            'phone' => $request->phone
        ];

        if ($request->password && $request->password != '') {
            $to_update['password'] = $request->password;
        }

        $user->update($to_update);

        return redirect()->route('admin.users.edit', $user->id)->with("success", "User updated successfully!");
    }

    public function delete($id) {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back();
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    public function edit($id) {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()-with('error', 'User not found!');
        }

        return view('admin.pages.user-edit', [
            'user' => $user,
            'availableSettings' => $user->getSettings()
        ]);
    }

    public function adminLoginAs($id) {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back();
        }

        Auth::login($user);

        return redirect()->route("userProfile", $user->displayname)->with('success', 'Logged in as ' . $user->name);
    }
}
