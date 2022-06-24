<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminNavButton extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $icon;
    public $name;
    public $route;
    public function __construct($icon,$name,$route)
    {
        $this->icon = $icon;
        $this->name = $name;
        $this->route = $route;
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.navbutton');
    }
}
