<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;

class KanbanTasks extends Component
{
    public $project;
    public $searchValue = [];
    public $tasks;

    public function mount($project)
    {
        $user =  Auth::user();
        if($project != null) {
            $user->project_id = $project->id;
            $user->save();
        }
        $projectId = $user->project_id;
        $this->project = Project::find($projectId);

        $this->searchValue = array_merge([['project_id', $user->project_id]], $this->searchValue);
    }

    public function render()
    {
        $this->tasks = Task::where($this->searchValue)->get();
        $this->kanbanLists = TaskStatus::where("project_id", $this->project->id)->orderBy('kanban_list_rank')->get();

        return view('livewire.kanban-tasks');
    }
}
