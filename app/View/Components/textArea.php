<?php

namespace App\View\Components;

use Illuminate\View\Component;

class textArea extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $descripcion;
    public $idname;
    public function __construct($descripcion, $idname)
    {
        $this->descripcion = $descripcion;  
        $this->idname = $idname;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.text-area');
    }
}
