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

    public function deleteProject(Project $project)
    {
        $project->delete();
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
            $this->projects = Project::all()->sortBy('status');
        } else{
            $projects = UserProject::select('project_id')
                ->where([['user_id', '=', Auth::user()->id], ['status', '=', 'GRANTED']])->get();
            $this->projects = Project::whereIn('id', $projects)->get();
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
