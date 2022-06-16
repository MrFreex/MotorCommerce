<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APPagesController extends Controller
{
    public function home() {
        return view('admin.home');
    }
}
