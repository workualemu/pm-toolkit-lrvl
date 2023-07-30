<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class KanbanTasks extends Component
{
    public $project;
    public $searchValue = [];
    public $tasks;

    public function mount($project_id)
    {
        $user =  Auth::user();
        if($project_id > 0) {
            $user->project_id = $project_id;
            $user->save();
        }
        $projectId = $user->project_id;
        $this->project = Project::find($projectId);

        $this->searchValue = array_merge([['project_id', $user->project_id]], $this->searchValue);
    }

    public function render()
    {
        $this->tasks = Task::where($this->searchValue)->get();
        $this->kanbanLists = \App\Models\TaskStatus::get();

        return view('livewire.kanban-tasks');
    }
}
