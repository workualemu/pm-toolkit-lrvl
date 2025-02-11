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

    public $filterParams = [];
    // protected $listeners = [
    //     'refreshSingleTask' => 'forwardTaskRefresh'
    // ];

    // public function forwardTaskRefresh($taskId)
    // {
    //     logger('onRefreshSingleTask in Tasks');

    //     $this->emitTo('task-component-{$taskId}', 'refreshTaskComponent', $taskId);

    // }

    // public function mount($tasks)
    // {
    //     // logger('in task-list mount');
        
    //     $this->filterParams = $filterParams;
    // }

    // #[On('tasksUpdated')]
    // public function updateTasks($tasks)
    // {
    //     logger($tasks);
    //     $this->tasks = collect(json_decode($tasks))->map(fn($task) => (object) $task);
    // }

    public function render()
    {
        // if (!$this->hasGeneratedTasks) {
        //     $this->tasks = $this->getTasks();
        //     $this->hasGeneratedTasks = true;
        // }
        return view('livewire.partials.tasks.task-list');
    }
}
