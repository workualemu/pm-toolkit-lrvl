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
        if($project_id > 0) {
            $user->project_id = $project_id;
            $user->save();
        }
        $projectId = $user->project_id;
        $this->project = Project::find($projectId);

        $this->searchValue = array_merge([['project_id', $user->project_id]], $this->searchValue);
    }

    public function render()
    {
        $this->statuses = TaskStatus::all();
        $this->phases = Task::where(array_merge([['parent', 0]], $this->searchValue))->get();
        // $this->searchValue = $this->searchValue . ' AND (' . "title LIKE '%". $this->searchTerm . "%')";

        if(!empty($this->searchTerm)) {
            $tasks1 = Task::where(function($query)
            {
                $query->where('title', 'Like', "%".$this->searchTerm."%");
            })->where($this->searchValue)->paginate(10);
        } else {
            $tasks1 = Task::where($this->searchValue)->paginate(5);
        }
        
        // 
        // $tasks1 = $tasks1->map( function ($task) {
        //     $progress = $task->progress * 100;
        //     if( $progress < 1){ 
        //         $task->color = 'bg-slate-150';
        //     } elseif($progress < 40){ 
        //         $task->color = 'bg-red-500';
        //     } elseif($progress < 90){ 
        //         $task->color = 'bg-yellow-500';
        //     } else{
        //         $task->color = 'bg-green-500';
        //     }  
        //     return $task;
        // } );

        // return view('livewire.tasks');
        return view('livewire.tasks', [
            'tasks' =>  $tasks1,
        ]);
    }
}
