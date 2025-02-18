<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\UserProject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class Projects extends Component
{
    public $projects;
    public $colors = ['info', 'primary', 'secondary', 'success', 'error', 'warning'];
    public $dropMenus = ['info', 'primary', 'secondary', 'success', 'error', 'warning'];
    public $errorMessage='';

    public $searchTerm;
    public $projectToDelete;
    public $showProjectModal = false; // Define showProjectModal property
    public $showDeleteModal = false; 

    #[On('refreshProjects')]
    public function onRefreshProjects()
    {
        $this->dispatch('$refresh');
    }

    #[On('errorCreatingProjectFromTemplate')]
    public function onErrorCreatingProjectFromTemplate($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    public function newProject()
    {
        $this->dispatch('openProjectModal',null);
    }

    public function editProject(Project $project)
    {
        $this->dispatch('openProjectModal', $project);
    }

    public function manageProjectUsers(Project $project)
    {
        return redirect()->route('project-users', ['project_id'=>$project->id]);
    }

    // public function deleteProject($projectId)
    // {
    //     $project = Project::find($projectId);
    //     if ($project) {
    //         $project->delete();
    //         $this->dispatch('refreshProjects');
    //     }
    // }

    public function showDeleteProjectModal($projectId)
    {
        $this->projectToDelete = Project::find($projectId);

        if ($this->projectToDelete) {
            $this->showDeleteModal = true;
        }
    }

    public function deleteProject()
    {
        if ($this->projectToDelete) {
            $this->projectToDelete->delete();
            $this->dispatch('refreshProjects');
            $this->showDeleteModal = false;
        }
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
