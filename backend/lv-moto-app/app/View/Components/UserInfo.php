<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Facades\Auth;

class UserInfo extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $displayName;
    public $avatar;
    public $isAdmin;
    public $username;
    public function __construct()
    {
        $this->username = auth()->user()->username;
        $this->displayName = auth()->user()->name;
        $this->avatar = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png";
        $this->isAdmin = auth()->user()->canUseAdminPanel();
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user-info');
    }
}
