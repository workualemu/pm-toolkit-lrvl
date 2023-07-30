<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;
    public $limit = 1;
 
    public function mount($par)
    {
        $this->limit = $par;
    }

    public function increment()
    {
        $this->count++;
    }


    public function render()
    {
        return view('livewire.counter');
        
        return view('livewire.counter', [
            'limit' => $this->limit,
        ]);
    }
}
