<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Task extends Component
{
    public $showModal = false;
    public \App\Models\Task $task;

    public function openModal($task_id)
    {

        $this->emit('openTaskModal', $task_id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function storeTask($task)
    {
        $this->reset(['title']);
        $this->showModal = false;

    }

    public function mount($task_id)
    {

        $this->task = \App\Models\Task::find($task_id);
    }

    public function render()
    {
        return view('livewire.task');
    }
}
