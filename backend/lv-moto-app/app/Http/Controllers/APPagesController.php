<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class APPagesController extends Controller
{
    public function home() {
        return view('admin.home')->with([
            'countUsers' => User::count(),
            'countAdmins' => User::where('permission', '<>', 'user')->count(),
        ]);
    }

    public function searchUsers(Request $request) {
        return redirect()->route("admin.users", Array($request->search, $request->field));
    }

    public function users($search = false, $field = false) {
        $list = $search && $field ? User::where($field, 'like', '%' . $search . '%')->get() : User::all(); 
        return view('admin.pages.users')->with([
            'users' => $list,
        ]);
    }
}
