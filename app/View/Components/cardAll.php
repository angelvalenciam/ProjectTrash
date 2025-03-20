<?php

namespace App\View\Components;

use Illuminate\View\Component;

class cardAll extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $title;
    public $desc;

    public function __construct($title, $desc)
    {
      $this->title = $title;
      $this->desc = $desc;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card-all');
    }
}
