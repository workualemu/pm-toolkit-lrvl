<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PrivacyModal extends Component
{
    public $show = false;

    public function render()
    {
        return view('livewire.privacy-modal');
    }

    public function toggle()
    {
        $this->show = !$this->show;
    }
}