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

Route::prefix('userSettings')->group(function() {
    Route::get('/', "UserController@showSettings")->name('userSettings');
    Route::post('/apply', "UserController@applySettings")->name('applySettings');
    Route::post('/changePassword', "UserController@changePassword")->name('changePassword');
});

Route::prefix('admin')->middleware('EnsureAdminUser')->group(function() {
    Route::get('/', "APPagesController@home")->name('admin');
});

Route::post('/confirmLogin', "LoginController@validateLoginForm");
Route::post('/confirmRegister', "RegisterController@validateRegister");
Route::post('/upload/bg', "UploadController@uploadBg");
Route::post('/upload/avatar', "UploadController@uploadAvatar");
