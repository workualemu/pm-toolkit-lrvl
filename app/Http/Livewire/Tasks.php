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

    protected $listeners = ['refreshTasks' => 'refreshPage'];
    public function refreshPage()
    {
        $refresh;
    }
    
    public function newTask()
    {
        $user =  Auth::user();
        $projectId = $user->project_id;
        $project = Project::find($projectId);

        $this->emit('openTaskModal', 0);
        $this->showModal = true;
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
        $this->tasks = Task::where('project_id', $user->project_id)->get();
    }

    public function render()
    {
        return view('livewire.tasks');
    }
}
