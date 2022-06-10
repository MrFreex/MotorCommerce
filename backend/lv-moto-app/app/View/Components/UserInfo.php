<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UserInfo extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $displayName;
    public $avatar;
    public function __construct()
    {
        $this->displayName = "Test user";
        $this->avatar = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png";
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
