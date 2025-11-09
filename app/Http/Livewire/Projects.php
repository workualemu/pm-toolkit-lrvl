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

    public function updatedSearchTerm()
    {
        $this->dispatch('$refresh');
    }

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
        $searchTerm = '%' . strtolower($this->searchTerm) . '%';
        if(Auth::user()->hasRole('Super Admin') ){
            $projectsQuery = Project::where('is_template', false)
            ->when($this->searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereRaw('LOWER(title) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(description) LIKE ?', [$searchTerm]);
                });
            });
            $this->projects = $projectsQuery->get()->sortBy('status');
        } else{
            $projectsQuery = Auth::user()->projects() 
                ->where('projects.is_template', false) 
                ->wherePivot('status', 'GRANTED') 
                ->when($this->searchTerm, function ($query) {
                    $searchTerm = strtolower("%{$this->searchTerm}%"); 
                    $query->where(function ($q) use ($searchTerm) {
                        $q->whereRaw('LOWER(projects.title) LIKE ?', [$searchTerm])
                        ->orWhereRaw('LOWER(projects.description) LIKE ?', [$searchTerm]);
                    });
                });
            $this->projects = $projectsQuery->get()->sortBy('status');
        }

        $totalProjects = $this->projects->count();
        $inProgressProjects = $this->projects->where('status', '1-in-progress')->count();
        $onHoldProjects = $this->projects->where('status', '2-on-hold')->count();
        $completedProjects = $this->projects->where('status', '3-completed')->count();

        return view('livewire.projects', [
            'totalProjects' => $totalProjects,
            'inProgressProjects' => $inProgressProjects,
            'completedProjects' => $completedProjects,
            'onHoldProjects' => $onHoldProjects,
        ]);
    }
}
