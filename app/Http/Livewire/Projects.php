<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

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

        // $this->redirect('project-users', ['project-id'=>$project->id]); 
        // $this->emit('openProjectUsersPage', $project);
    }

    public function deleteProject(Project $project)
    {
        dd('delete');
    }


    // public function applyFilter()
    // {
    //     $this->filterStatuses = [];
    //     foreach($this->statuses as $status){
    //         if(isset($this->fStatus[$status->id]) && $this->fStatus[$status->id]){
    //            array_push($this->filterStatuses, $status->id) ;
    //         }
            
    //     }
    //     $user =  Auth::user();
    //     // dd($this->tempStatus);
    //     $this->render();
    //     // $this->searchValue = array_merge([['project_id', $user->project_id]], $condition);
    // }

    // public function filterTasks($condition)
    // {
    //     $user =  Auth::user();
    //     $this->searchValue = array_merge([['project_id', $user->project_id]], $condition);
    // }

    // public function filterMyAssignedTasks()
    // {
    //     $user =  Auth::user();
    //     $this->searchValue = [['assigned_to', $user->id]];

    //     $this->searchValue = array_merge([['project_id', $user->project_id]], $this->searchValue);
    // }

    // public function allTasks()
    // {
    //     $user =  Auth::user();
    //     $this->searchValue = [['project_id', $user->project_id]];
    // }

    public function mount()
    {
        // $user =  Auth::user();
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
        $this->projects = Project::all()->sortBy('status');
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
