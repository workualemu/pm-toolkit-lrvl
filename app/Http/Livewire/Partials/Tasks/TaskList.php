<?php

namespace App\Http\Livewire\Partials\Tasks;

use Livewire\Component;
use App\Models\Task;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\On;

class TaskList extends Component
{
    #[Reactive]
    public $tasks;

 

    public function render()
    {
        return view('livewire.partials.tasks.task-list');
    }
}
