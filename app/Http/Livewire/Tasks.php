<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class Tasks extends Component
{
    public $showModal = false;
    public $project;
    public $tasks;
    public $searchValue = [];

    protected $listeners = ['refreshTasks' => '$refresh', 
                            'openNewTaskModal' => 'newTask',
                            'filterTasks' => 'filterTasks',
                            'showAllTasks' => 'allTasks'
                        ];
    
    public function newTask()
    {
        $user =  Auth::user();
        $projectId = $user->project_id;
        $project = Project::find($projectId);

        $this->emit('openTaskModal', 0);
        $this->showModal = true;
    }
    
    public function filterTasks($condition)
    {
        $user =  Auth::user();
        $this->searchValue = array_merge([['project_id', $user->project_id]], $condition);
    }

    public function filterMyAssignedTasks()
    {
        $user =  Auth::user();
        $this->searchValue = [['assigned_to', $user->id]];

        $this->searchValue = array_merge([['project_id', $user->project_id]], $this->searchValue);
    }

    public function allTasks()
    {
        $user =  Auth::user();
        $this->searchValue = [['project_id', $user->project_id]];
    }

    public function mount($project_id)
    {
        $user =  Auth::user();
        if($project_id > 0){
            $user->project_id = $project_id;
            $user->save();
        }
        $projectId = $user->project_id;
        $this->project = Project::find($projectId);
        
        $this->searchValue = array_merge([['project_id', $user->project_id]], $this->searchValue);
    }

    public function render()
    {
        $this->tasks = Task::where($this->searchValue )->get();
        return view('livewire.tasks');
    }
}
