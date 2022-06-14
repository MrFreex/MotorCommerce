<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('homepage');
});

Route::get('/login', "LoginController@showLoginForm"); 
Route::get('/logout', "LoginController@logout");
Route::get('/register', "RegisterController@show");

Route::get('/userProfile/{username}/{usePopup?}', "UserProfileController@show")->name('userProfile');

Route::post('/confirmLogin', "LoginController@validateLoginForm");
Route::post('/confirmRegister', "RegisterController@validateRegister");
Route::post('/upload/bg', "UploadController@uploadBg");
