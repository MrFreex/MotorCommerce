<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = ['username', 'email', 'password','email_verified_at'];
    protected $primaryKey = 'username';

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function getAuthIdentifier() {
        return $this->username;
    }

    public function getAuthPassword() {
        return $this->password;
    }

    public function getRememberToken() {
        return $this->remember_token;
    }

    public function setRememberToken($value) {
        $this->remember_token = $value;
    }

    public function getRememberTokenName() {
        return 'remember_token';
    }

    public function get($username) {
        $user = User::where('username', $username)->first();
        return $user;
    }
}
