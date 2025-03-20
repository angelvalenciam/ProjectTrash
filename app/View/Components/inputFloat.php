<?php

namespace App\View\Components;

use Illuminate\View\Component;

class inputFloat extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $pnombre;
    public $nombre;
    public $idInput;
    public $idphp;
    public function __construct($pnombre, $nombre, $idInput, $idphp)
    {
        $this->pnombre = $pnombre;
        $this->nombre = $nombre;
        $this->idInput = $idInput;
        $this->idphp = $idphp;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input-float');
    }
}
