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
    public $searchTerm;
    public $searchValue = [];

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

    // public function onUpdateTaskList($taskIds)
    // {
    //     $this->tasks = Task::whereIn('id', $taskIds)->get();
    // }

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
        $this->filterParams = [
            'fTitle' => '',
            'fPhase' => '',
            'fDateFrom' => '',
            'fDateTo' => '',
            'fStatus' => [],
            'searchTerm' => '',
            'searchValue' => $this->searchValue,
        ];
        $this->emit('resetParams', $this->filterParams);
    }

    public function toggleRead($id)
    {
        
        // $notification = $this->user->notifications()->where('id', $id)->first();

        // if(isset($notification)){
        //     if($notification->read()){
        //         $notification->markAsUnread();
        //     } else {
        //         $notification->markAsRead();
        //     }
        // }
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

        $this->filterParams = [
            'fTitle' => '',
            'fPhase' => '',
            'fDateFrom' => '',
            'fDateTo' => '',
            'fStatus' => '',
            'searchTerm' => '',
            'searchValue' => $this->searchValue,
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
        // dd($user->notifications);
        $projectId = $user->project_id;
        $this->project = Project::find($projectId);

        $this->searchValue = array_merge([['project_id', $user->project_id]], $this->searchValue);

        $this->filterParams = [
            'fTitle' => $this->fTitle,
            'fPhase' => $this->fPhase,
            'fDateFrom' => $this->fDateFrom,
            'fDateTo' => $this->fDateTo,
            'fStatus' => $this->selectedStatuses,
            'searchTerm' => $this->searchTerm,
            'searchValue' => $this->searchValue,
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if($this->tasks == null || $this->tasks->count() == 0){
            $clause = $this->searchValue;
            $this->tasks = Task::whereNull('parent')
            ->with([
                'children' => function ($query) use ($clause){
                    $query->whereHas('children', function ($q) use ($clause){
                        $q->where($clause);
                    });
                    $query->orWhere($clause);                   
                }, 
                'children.children' => function ($query) use ($clause){
                    $query->where($clause);
                }
            ])
            ->orderBy('list_order')
            ->get();
        }
        
        

        return view('livewire.tasks');
    }


    // public function render()
    // {

    //     $this->statuses = TaskStatus::all();
    //     $this->phases = Task::where(array_merge([['parent', 0]], $this->searchValue))->get();

    //     $qBuilder = Task::query();
        
    //     $qBuilder = $qBuilder->when(count($this->filterStatuses) > 0, function ($query) {
    //         $query->whereIn('task_status_id', $this->filterStatuses);
    //     });

    //     $qBuilder = $qBuilder->when(!empty($this->searchTerm), function ($query) {
    //         $query->where('title', 'Like', "%".$this->searchTerm."%");
    //     });

    //     $tasks1 = $qBuilder->where($this->searchValue)->paginate(10);
        
    //     foreach( $tasks1 as $task) {
    //         $task->progress = number_format($task->progress * 100, 2);
    //         if( $task->progress < 1){ 
    //             $task->color = 'bg-slate-150';
    //         } elseif($task->progress < 40){ 
    //             $task->color = 'bg-red-500';
    //         } elseif($task->progress < 90){ 
    //             $task->color = 'bg-yellow-500';
    //         } else{
    //             $task->color = 'bg-green-500';
    //         }  
    //     } ;

    //     $st = $this->searchTerm==null ? '%' : '%'.$this->searchTerm.'%';

    //     $clause = [['title', 'Like', $st]];
    //     $clause = array_merge($this->searchValue, $clause);

    //     $tasks2 = Task::whereNull('parent')
    //         ->with([
    //             'children' => function ($query) use ($clause){
    //                 $query->whereHas('children', function ($q) use ($clause){
    //                     $q->where($clause);
    //                 });
    //                 $query->orWhere($clause);                   
    //             }, 
    //             'children.children' => function ($query) use ($clause){
    //                 $query->where($clause);
    //             }
    //         ])
    //         ->orderBy('list_order')
    //         ->get();


    //     return view('livewire.tasks', [
    //         'tasks' =>  $tasks2,
    //     ]);
    // }
}
