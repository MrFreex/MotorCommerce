<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    Route::prefix('users')->group(function() {
        Route::get('/list/{search?}/{field?}', "APPagesController@users")->name('admin.users');
        
        Route::post('/list/search', "APPagesController@searchUsers")->name('admin.users.search');
        
        Route::get('/delete/{id}', "UserController@delete")->name('admin.users.delete');
        Route::get('/edit/{id}', "UserController@edit")->name('admin.users.edit');
        Route::get('/create', "UserController@createview")->name('admin.users.create');
        Route::get('/loginas/{id}', "UserController@adminLoginAs")->name('admin.users.loginas');

        Route::post('/confirmEdit', "UserController@confirmEdit")->name('admin.users.confirmEdit');
        Route::post('/confirmCreate', "UserController@confirmCreate")->name('admin.user.confirmCreate');
    });
});

Route::post('/confirmLogin', "LoginController@validateLoginForm");
Route::post('/confirmRegister', "RegisterController@validateRegister");
Route::post('/upload/bg', "UploadController@uploadBg");
Route::post('/upload/avatar', "UploadController@uploadAvatar");
