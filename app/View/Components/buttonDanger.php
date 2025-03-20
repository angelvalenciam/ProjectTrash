<?php

namespace App\View\Components;

use Illuminate\View\Component;

class buttonDanger extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $buttonName;
    public function __construct($buttonName)
    {
        $this->buttonName = $buttonName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button-danger');
    }
}
