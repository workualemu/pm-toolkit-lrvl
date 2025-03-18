<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TermsModal extends Component
{
    public $show = false;

    public function render()
    {
        return view('livewire.terms-modal');
    }

    public function toggle()
    {
        $this->show = !$this->show;
    }
}