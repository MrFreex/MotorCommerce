<?php

namespace App\View\Components;

use Illuminate\View\Component;

class usInputField extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $fieldName;
    public $inputType;
    public $inputValue;
    public $name;
    public $mandatory;
    public function __construct($name, $inputtype = "text", $formname, $mandatory, $value = "")
    {
        $this->fieldName = $name;
        $this->inputType = $inputtype;
        $this->inputValue = $value;
        $this->name = $formname;
        $this->mandatory = $mandatory;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.us-input-field');
    }
}
