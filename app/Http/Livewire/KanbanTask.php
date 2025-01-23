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
        $this->emit('openTaskModal', $this->task->parent, $this->task->id, $this->task->level);
        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.kanban-task');
    }
}
