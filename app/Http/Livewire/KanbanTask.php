<?php

namespace App\Http\Livewire;

use Livewire\Component;

class KanbanTask extends Component
{
    
    public $task;
    public $searchValue = [];

    public function render()
    {
        return view('livewire.kanban-task');
    }
}
