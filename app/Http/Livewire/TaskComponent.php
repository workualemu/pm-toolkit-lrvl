<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;

class TaskComponent extends Component
{
    public $showModal = false;
    public Task $task;
    public $task_id = 0;
    public $isStarred = false;

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
        $this->isStarred = $task->is_starred;
        // dd($task);
        // $this->task_id = $task_id;
        // $this->task = \App\Models\Task::find($task_id);
        // dd($this->task);
    }

    public function setStarred()
    {
        $this->task->is_starred = $this->isStarred;
        $this->task->save();
    }

    public function filterByStatus($status)
    {
        $this->emit('filter-by-status', $status);
    }

    public function render()
    {
        if($this->task->level == 0){
            $this->task->padding = 'pl-2';
            $this->task->bgColor = 'bg-blue-200';
        } elseif($this->task->level == 1){
            $this->task->padding = 'pl-4';
            $this->task->bgColor = 'bg-blue-50';
        } else {
            $this->task->padding = 'pl-6';
            $this->task->bgColor = 'white';
        }
        return view('livewire.task-component');
    }
}
