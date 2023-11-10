<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Dropmenu extends Component
{
    /**
     * The dropwdown name.
     *
     * @var string
     */
    public $name;

    /**
     * The dropdown options.
     *
     * @var string
     */
    public $options;

    /**
     * The dropdown options.
     *
     * @var string
     */
    public $record;

    /**
     * Dropdown panel position
     */
    public $panelPosition;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $options, $record, $panelPosition = 'left')
    {
        $this->name = $name;
        $this->options = $options;
        $this->record = $record;
        if($panelPosition == 'left'){
            $this->panelPosition = 'right';
        }
        if($panelPosition == 'right'){
            $this->panelPosition = 'left';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dropmenu');
    }
}