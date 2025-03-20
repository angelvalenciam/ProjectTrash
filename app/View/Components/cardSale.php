<?php

namespace App\View\Components;

use Illuminate\View\Component;

class cardSale extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $title;
    public $price;
    public $description;
    public $buttonName;

    public function __construct($title, $price, $description, $buttonName)
    {
        $this->title = $title;
        $this->price = $price;
        $this->description = $description;
        $this->buttonName = $buttonName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card-sale');
    }
}
