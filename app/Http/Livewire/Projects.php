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

    public $searchTerm;
    public $projectToDelete;
    public $showProjectModal = false; // Define showProjectModal property
    public $showDeleteModal = false; 


    protected $listeners = ['refreshProjects' => '$refresh'
                        ];

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

    // public function deleteProject($projectId)
    // {
    //     $project = Project::find($projectId);
    //     if ($project) {
    //         $project->delete();
    //         $this->emit('refreshProjects');
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
            $this->emit('refreshProjects');
            $this->showDeleteModal = false;
        }
    }

    public function mount()
    {
        
        // if($project != null) {
        //     $user->project_id = $project->id;
        //     $user->save();
        // }
        // $projectId = $user->project_id;
        // $this->project = Project::find($projectId);

        // $this->searchValue = array_merge([['project_id', $user->project_id]], $this->searchValue);
    }

    public function render()
    {
        if(Auth::user()->hasRole('Super Admin') ){
            $this->projects = Project::where('is_template', false)->get()->sortBy('status');
        } else{
            $this->projects = Auth::user()->projects->where('is_template', false)
                ->where('status', '=', 'GRANTED');
        }
        
        
        // $this->phases = Task::where(array_merge([['parent', 0]], $this->searchValue))->get();

        // $qBuilder = Task::query();

        // $qBuilder = $qBuilder->when(count($this->filterStatuses) > 0, function ($query) {
        //     $query->whereIn('task_status_id', $this->filterStatuses);
        // });

        // $qBuilder = $qBuilder->when(!empty($this->searchTerm), function ($query) {
        //     $query->where('title', 'Like', "%".$this->searchTerm."%");
        // });

        // $tasks1 = $qBuilder->where($this->searchValue)->paginate(10);
        
        // foreach( $tasks1 as $task) {
        //     $task->progress = number_format($task->progress * 100, 2);
        //     if( $task->progress < 1){ 
        //         $task->color = 'bg-slate-150';
        //     } elseif($task->progress < 40){ 
        //         $task->color = 'bg-red-500';
        //     } elseif($task->progress < 90){ 
        //         $task->color = 'bg-yellow-500';
        //     } else{
        //         $task->color = 'bg-green-500';
        //     }  
        // } ;

        return view('livewire.projects', [
            'projects' =>  $this->projects
        ]);
    }
}
