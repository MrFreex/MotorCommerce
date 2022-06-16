<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserSetting {
    public $label;
    public $name;
    public $value;
    public $placeholder;
    public $type;
    public $mandatory;

    function __construct($name,$value,$label,$mandatory = false, $type = "text", $placeholder = false) {
        if (!$placeholder) {
            $placeholder = $label;
        }

        $this->name = $name;
        $this->value = $value;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->type = $type;
        $this->mandatory = $mandatory;
    }
}

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /*
        'name' => 'Name',
        'username' => 'Username',
        'password' => 'Password',
        'phone' => 'Phone Number (optional)',
        'birthday' => 'Birthday (optional)',
        'address' => 'Billing Address',
        'city' => 'City',
        'state' => 'State',
        'zip' => 'Zip Code',
        'country' => 'Country',
    */

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'displayname',
        'password',
        'avatar',
        'profileBg',
        'phone',
        'address',
        'birthday',
        'city',
        'state',
        'zip',
        'country'
    ];

    protected $adminGroups = [
        'root',
        'manager'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    

    /**
     * Always encrypt password when it is updated.
     *
     * @param $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
        $this->save();
    }

    public function canUseAdminPanel()
    {
        return in_array($this->permission, $this->adminGroups);
    }

    public function getSettings() {
        return [
            new UserSetting('name', $this->name, 'Name', true),
            new UserSetting('username', $this->username, 'Username', true),
            new UserSetting('displayname', $this->displayname, 'Display Name', true),
            new UserSetting('email', $this->email, 'Email', true),
            new UserSetting('phone', $this->phone, 'Phone Number', false, 'tel'),
            new UserSetting('birthday', $this->birthday, 'Birthday', true, 'date'),
            new UserSetting('address', $this->address, 'Billing Address', false, 'address'),
            new UserSetting('city', $this->city, 'City'),
            new UserSetting('state', $this->state, 'State'),
            new UserSetting('zip', $this->zip, 'Zip Code', false, 'number'),
            new UserSetting('country', $this->country, 'Country')
        ];
    }

    public function applySettings($settings) {
        foreach ($settings as $sname => $setting) {
            $this->update([$sname => $setting]);
        }

        return true;
    }
}