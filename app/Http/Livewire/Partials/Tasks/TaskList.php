<?php

namespace App\Http\Livewire\Partials\Tasks;

use Livewire\Component;
use App\Models\Task;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;

class TaskList extends Component
{
    #[Reactive]
    public $tasks;

    // public $filterParams = [];


    public function render()
    {
        // if (!$this->hasGeneratedTasks) {
        //     $this->tasks = $this->getTasks();
        //     $this->hasGeneratedTasks = true;
        // }
        return view('livewire.partials.tasks.task-list');
    }
}
