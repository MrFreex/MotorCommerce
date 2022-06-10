<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = ['username', 'email', 'password','email_verified_at'];
    protected $primaryKey = 'username';

    public function get($username) {
        $user = User::where('username', $username)->first();
        return $user;
    }
}
