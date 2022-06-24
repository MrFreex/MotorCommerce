<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function list($query = false, $field = false) {
        return view('admin.pages.orders');
    }
}
