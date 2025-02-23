<?php

namespace App\Http\Livewire\Tasks;

use Livewire\Component;
use App\Models\Task;

class TaskTable extends TasksView
{
    public function mount($filterParams)
    {
        $this->filterParams = $filterParams;
    }

    public function render()
    {
        if (!$this->hasGeneratedTasks) {
            $this->tasks = $this->getTasks();
            $this->hasGeneratedTasks = true;
        }
        return view('livewire.tasks.task-table');
    }
}
