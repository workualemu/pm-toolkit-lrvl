<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\UserProject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Projects extends Component
{
    public $projects;
    public $colors = ['info', 'primary', 'secondary', 'success', 'error', 'warning'];
    public $dropMenus = ['info', 'primary', 'secondary', 'success', 'error', 'warning'];
    public $errorMessage='';

    public $searchTerm;

    protected $listeners = ['refreshProjects' => '$refresh',
                        'errorCreatingProjectFromTemplate' => 'onErrorCreatingProjectFromTemplate'];

    public function onErrorCreatingProjectFromTemplate($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    public function newProject()
    {
        $this->emit('openProjectModal',null);
    }

    public function editProject(Project $project)
    {
        $this->emit('openProjectModal', $project);
    }

    public function manageProjectUsers(Project $project)
    {
        return redirect()->route('project-users', ['project_id'=>$project->id]);
    }

    public function deleteProject(Project $project)
    {
        $project->delete();
    }

    public function render()
    {
        if(Auth::user()->hasRole('Super Admin') ){
            $this->projects = Project::where('is_template', false)->get()->sortBy('status');
        } else{
            $this->projects = Auth::user()->projects->where('is_template', false)
                ->where('status', '=', 'GRANTED');
        }
        
        return view('livewire.projects');
    }
}
