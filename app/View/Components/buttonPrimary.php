<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ButtonPrimary extends Component
{
    /**
     * El nombre del botón.
     *
     * @var string
     */
    public $buttonName;

    /**
     * El tipo del botón.
     *
     * @var string
     */
    public $buttonType;

    /**
     * Crear una nueva instancia del componente.
     *
     * @param  string  $buttonName
     * @param  string  $buttonType
     * @return void
     */
    public function __construct($buttonName, $buttonType = 'button')
    {
        $this->buttonName = $buttonName;
        $this->buttonType = $buttonType;
    }

    /**
     * Obtener la vista / el contenido que representa el componente.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button-primary');
    }
}
