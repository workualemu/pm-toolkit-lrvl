<?php

namespace App\Http\Livewire;

use Livewire\Component;

class KanbanTask extends Component
{
    
    public $task;
    public $searchValue = [];
    public $showModal = false;

    public function openModal($task_id)
    {

        $this->emit('openTaskModal', $task_id);
        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.kanban-task');
    }
}
