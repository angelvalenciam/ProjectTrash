<?php

namespace App\View\Components;

use Illuminate\View\Component;

class cardContainers extends Component
{
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public $title;
  public $desc;
  public $kg;
  public $info;

  public function __construct($title, $desc, $kg, $info)
  {
    $this->title = $title;
    $this->desc = $desc;
    $this->kg = $kg;
    $this->info = $info;
  }
  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.card-containers');
  }
}
