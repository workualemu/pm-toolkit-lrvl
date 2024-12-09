<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class Tasks extends Component
{
    use WithPagination;

    public $showModal = false;
    public $project;
    public $tasks = null;
    public $statuses;
    public $phases;
    public $searchTerm = null;
    public $sidebarFilter = [];

    public $fTitle = '';
    public $fPhase;
    public $fDateFrom;
    public $fDateTo;
    public $selectedStatuses = [];
    public $filterStatuses = [];

    public $filterParams = [];

    public Illuminate\Database\Eloquent\Collection $result;

    protected $listeners = ['refreshTasks' => '$refresh',
                            'openNewTaskModal' => 'newTask',
                            'filterTasks' => 'filterTasks',
                            'showAllTasks' => 'allTasks',
                            'gantt-task-dragged' => 'onGanttTaskDrag',
                        ];

    public function onGanttTaskDrag($taskId, $mode, $task, $original)
    {

    }

    public function addNewPhase()
    {
        $user =  Auth::user();
        $projectId = $user->project_id;
        $project = Project::find($projectId);

        $this->emit('openTaskModal', 0, 0);
        $this->showModal = true;
    }

    public function filterTasks($condition)
    {
        $user =  Auth::user();
        $sidebarFilter = [['type'=>'where','column'=>'project_id', 'value'=>$user->project_id]];
        if($condition != null){
            array_push($sidebarFilter, $condition);
        }
        $this->filterParams = [
            'fTitle' => null,
            'fPhase' => null,
            'fDateFrom' => null,
            'fDateTo' => null,
            'fStatus' => [],
            'searchTerm' => null,
            'sidebarFilter' => $sidebarFilter,
            'fPriority' => null,
            'fTaskIds' => null,
            'fAssignee' => null,
        ];
        $this->emit('resetParams', $this->filterParams);
    }

    // public function toggleRead($id)
    // {
        
        // $notification = $this->user->notifications()->where('id', $id)->first();

        // if(isset($notification)){
        //     if($notification->read()){
        //         $notification->markAsUnread();
        //     } else {
        //         $notification->markAsRead();
        //     }
        // }
    // }

    public function allTasks()
    {
        $user =  Auth::user();
        $sidebarFilter = [['type'=>'where','column'=>'project_id', 'value'=>$user->project_id]];

        $this->filterParams = [
            'fTitle' => null,
            'fPhase' => null,
            'fDateFrom' => null,
            'fDateTo' => null,
            'fStatus' => [],
            'searchTerm' => null,
            'sidebarFilter' => $sidebarFilter,
            'fPriority' => null,
            'fTaskIds' => null,
            'fAssignee' => null,
        ];
        $this->refresh();
    }

    public function mount($project)
    {
        if($this->tasks == null){
            $this->tasks = collect();
        }
        $user =  Auth::user();
        if($project != null) {
            $user->project_id = $project->id;
            $user->save();
        }
        $projectId = $user->project_id;
        $this->project = Project::find($projectId);

        $sidebarFilter = [['type'=>'where','column'=>'project_id', 'value'=>$user->project_id]];

        $this->filterParams = [
            'fTitle' => $this->fTitle,
            'fPhase' => $this->fPhase,
            'fDateFrom' => $this->fDateFrom,
            'fDateTo' => $this->fDateTo,
            'fStatus' => $this->selectedStatuses,
            'searchTerm' => $this->searchTerm,
            'sidebarFilter' => $sidebarFilter,
            'fPriority' => null,
            'fTaskIds' => null,
            'fAssignee' => null,
        ];
    }

    public function render()
    {
        return view('livewire.tasks');
    }

}
