<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Navbutton extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $text;
    public $route;
    public $icon;
    public function __construct($text,$route,$icon)
    {
        $this->text = $text;
        $this->route = $route;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.navbutton');
    }
}
