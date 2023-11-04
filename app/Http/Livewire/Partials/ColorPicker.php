<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;
use Livewire\Attributes\Modelable;

class ColorPicker extends Component
{
    #[Modelable] 
    public $color ='';
    public $currentColor;
    public $pColor;
    public $pVariant;

    public function mount()
    {
        $this->pColor = 'blue';
        $this->pVariant = 300;
        // $this->currentColor = 'red-200';
    }

    public function render()
    {
        return view('livewire.partials.color-picker');
    }
}
