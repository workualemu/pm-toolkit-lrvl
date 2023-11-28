<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Task extends Component
{
    public $showModal = false;
    public \App\Models\Task $task;
    public $task_id = 0;

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

    public function mount($task)
    {

        
        $this->task = $task;
        // dd($task);
        // $this->task_id = $task_id;
        // $this->task = \App\Models\Task::find($task_id);
        // dd($this->task);
    }

    public function render()
    {
        // if($this->task->id != 7)
        //     dd($this->task);
        return view('livewire.task');
    }
}
