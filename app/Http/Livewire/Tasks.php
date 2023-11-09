<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Tasks extends Component
{
    use WithPagination;

    public $showModal = false;
    public $project;
    public $tasks2;
    public $statuses;
    public $phases;
    public $searchTerm;
    public $searchValue = [];

    public $fTitle = '';
    public $fPhase;
    public $fDateFrom;
    public $fDateTo;
    public $fStatus = [];
    public $filterStatuses = [];



    protected $listeners = ['refreshTasks' => '$refresh',
                            'openNewTaskModal' => 'newTask',
                            'filterTasks' => 'filterTasks',
                            'showAllTasks' => 'allTasks',
                            'gantt-task-dragged' => 'onGanttTaskDrag'
                        ];


    public function onGanttTaskDrag($taskId, $mode, $task, $original)
    {

    }

    public function newTask()
    {
        $user =  Auth::user();
        $projectId = $user->project_id;
        $project = Project::find($projectId);

        $this->emit('openTaskModal', 0);
        $this->showModal = true;
    }
    public function applyFilter()
    {
        $this->filterStatuses = [];
        foreach($this->statuses as $status){
            if(isset($this->fStatus[$status->id]) && $this->fStatus[$status->id]){
               array_push($this->filterStatuses, $status->id) ;
            }
            
        }
        $user =  Auth::user();
        // dd($this->tempStatus);
        $this->render();
        // $this->searchValue = array_merge([['project_id', $user->project_id]], $condition);
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->statuses = TaskStatus::all();
        $this->phases = Task::where(array_merge([['parent', 0]], $this->searchValue))->get();

        $qBuilder = Task::query();

        $qBuilder = $qBuilder->when(count($this->filterStatuses) > 0, function ($query) {
            $query->whereIn('task_status_id', $this->filterStatuses);
        });

        $qBuilder = $qBuilder->when(!empty($this->searchTerm), function ($query) {
            $query->where('title', 'Like', "%".$this->searchTerm."%");
        });

        $tasks1 = $qBuilder->where($this->searchValue)->paginate(10);
        
        foreach( $tasks1 as $task) {
            $task->progress = number_format($task->progress * 100, 2);
            if( $task->progress < 1){ 
                $task->color = 'bg-slate-150';
            } elseif($task->progress < 40){ 
                $task->color = 'bg-red-500';
            } elseif($task->progress < 90){ 
                $task->color = 'bg-yellow-500';
            } else{
                $task->color = 'bg-green-500';
            }  
        } ;

        // return view('livewire.tasks');
        return view('livewire.tasks', [
            'tasks' =>  $tasks1,
        ]);
    }
}
