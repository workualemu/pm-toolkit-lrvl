<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KanbanList extends Component
{
    public $tasks;
    public $kanbanList;

    protected $listeners = ['SortableEvent.onAdd' => 'incrementPostCount'];
 
    public function incrementPostCount()
    {
        dd('dragged');
    }

    public function mount()
    {
        $user =  Auth::user();

        $searchValue = [['project_id', $user->project_id]];
        $this->tasks = Task::where($searchValue )->get();

    }

    public function render()
    {
        // $this->tasks = Task::join('task_statuses', 'tasks.task_status_id', '=', 'task_statuses.id')
        //     ->where('task_statuses.id', $this->kanbanList->id)
        //     ->get();

        // $this->tasks = Task::whereHas('taskStatus' ,function($query)  {
        //     $query->where('kanban_list_id', '=', 2);
        // })->get();

        $this->tasks = Task::filterByKanban($this->kanbanList->id)->get();

        return view('livewire.kanban-list');
    }
}
