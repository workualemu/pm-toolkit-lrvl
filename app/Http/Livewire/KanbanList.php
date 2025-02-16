<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;

class KanbanList extends Component
{
    #[Reactive]
    public $statuses;
    
    public $tasks;
    // public $kanbanLists;


    public function mount()
    {
        // $this->tasks = Task::where("project_id", Auth::user()->project_id)->get();
        // $this->statuses = TaskStatus::where("project_id", Auth::user()->project_id)->orderBy('kanban_list_rank')->get();

    }

    // #[On('updateTaskOrder')]
    // public function updateTaskOrder($order, $status)
    // {
    //     $statusM = TaskStatus::find($status);
    //     logger('Status: ' . $statusM->value);
    //     foreach ($order as $index => $taskId) {
    //         // $task = Task::find($taskId);
    //         // logger($task->id . ' - ' . $task->title);
    //         Task::where('id', $taskId)->update([
    //             'kanban_list_rank' => $index + 1,
    //             'task_status_id' => $status
    //         ]);
    //     }

    //     // $this->tasks = Task::orderBy('kanban_list_rank')->get(); 
    // }

    public function render()
    {
        return view('livewire.kanban-list');
    }
}
