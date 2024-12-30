<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KanbanList extends Component
{
    public $tasks;
    public $kanbanList;
    public $taskStatus;

    protected $listeners = ['end-drag' => 'incrementPostCount'];

    public function incrementPostCount($taskId, $statusId, $rank)
    {
        $tasks = Task::getBeyondRank($statusId, $rank);
        foreach($tasks as $task) {
            $taskT = Task::find($task->id);
            $taskT->kanban_list_rank += 1;

            $taskT->save();
        }

        $task = Task::find($taskId);
        $task->task_status_id = $statusId;
        $task->kanban_list_rank = $rank;
        $task->save();
        $task->refresh();
    }

    public function mount()
    {
        $user =  Auth::user();

        $searchValue = [['project_id', $user->project_id]];
        $this->tasks = Task::where($searchValue)->get();

    }

    public function render()
    {
        $user =  Auth::user();
        $this->tasks = Task::filterByStatus($this->kanbanList->id, $user->project_id)->get();
        $this->taskStatus = TaskStatus::find($this->kanbanList->id);
        return view('livewire.kanban-list');
    }
}
