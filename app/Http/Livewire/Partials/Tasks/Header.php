<?php

namespace App\Http\Livewire\Partials\Tasks;

use Livewire\Component;
use App\Models\TaskStatus;
use App\Models\Task;

class Header extends Component
{

    public $phases =[];
    public $statuses =[];
    public $tasks = [];
    public $filterClause = [];

    public $searchTerm;
    public $fTitle = '';
    public $fPhase;
    public $fDateFrom;
    public $fDateTo;
    public $selectedStatuses = [];
    public $searchValue = [];

    public $filterParams = [];
    public $filterStatuses = [];
    

    
    // public function generateTasks()
    // {
    //     $query = Task::query();
    //     if (!empty($this->filterClause)) {
    //         foreach ($this->filterClause as $clause) {
    //             $query->where($clause);
    //         }
    //     }
    //     $this->tasks = $query->get();
    //     $this->emitUp('task-list-updated', $this->tasks);
    // }

    public function mount($filterParams)
    {
        $this->filterParams = $filterParams;
    }

    /**
     * Filters tasks based on the provided filtering variables.
     *
     * Filtering variables:
     * - $this->filterClause: Additional filter clauses.
     * - $this->searchTerm: Term to search in task titles and descriptions.
     * - $this->fTitle: Filter by title.
     * - $this->fPhase: Filter by phase.
     * - $this->fDateFrom: Filter tasks from this date.
     * - $this->fDateTo: Filter tasks up to this date.
     * - $this->selectedStatuses: Array of selected status IDs to filter tasks.
     *
     * @return tasks
     */
    public function applyFilter()
    {
        $this->filterParams = [
            'fTitle' => $this->fTitle,
            'fPhase' => $this->fPhase,
            'fDateFrom' => $this->fDateFrom,
            'fDateTo' => $this->fDateTo,
            'fStatus' => $this->selectedStatuses,
            'searchTerm' => $this->searchTerm,
            'searchValue' => $this->searchValue,
        ];

        $this->emit('taskListUpdated', $this->filterParams);
    }

    public function getTasks()
    {
        $query = Task::query();

        if (!empty($this->searchTerm)) {
            $query->where(function ($q) {
            $q->where('title', 'like', '%' . $this->searchTerm . '%')
              ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
            });
        }

        if (!empty($this->fTitle)) {
            $query->where('title', 'like', '%' . $this->fTitle . '%');
        }

        if (!empty($this->fPhase)) {
            $query->where('parent', $this->fPhase);
        }

        if (!empty($this->fDateFrom)) {
            $query->whereDate('created_at', '>=', $this->fDateFrom);
        }

        if (!empty($this->fDateTo)) {
            $query->whereDate('created_at', '<=', $this->fDateTo);
        }

        if (!empty($this->selectedStatuses)) {
            $query->whereIn('task_status_id', $this->selectedStatuses);
        }

        if (!empty($this->filterClause)) {
            foreach ($this->filterClause as $clause) {
                $query->where($clause);
            }
        }

        return $query->orderBy('list_order')->get();
    }

    public function getTasks2()
    {
        // $this->statuses = TaskStatus::all();
        // $this->phases = Task::where(array_merge([['parent', 0]], $this->searchValue))->get();

        $qBuilder = Task::query();
        
        $qBuilder = $qBuilder->when(count($this->filterStatuses) > 0, function ($query) {
            $query->whereIn('task_status_id', $this->filterStatuses);
        });

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

        // $st = $this->searchTerm==null ? '%' : '%'.$this->searchTerm.'%';

        $clause = [];
        if (!empty($this->searchTerm)) {
            $clause = [['title', 'Like', '%'.$this->searchTerm.'%']];
        }
        $clause = array_merge($this->searchValue, $clause);

        $qBuilder = Task::query();

        if (empty($this->fPhase)) {
            $qBuilder = $qBuilder->whereNull('parent');
        } else {
            $qBuilder = $qBuilder->where('parent', $this->fPhase);
        }

        // dd($qBuilder->toSql());
        // if(count($this->filterStatuses) > 0){
        //     $qBuilder->whereIn('task_status_id', $this->filterStatuses);
        // }
        // $qBuilder = $qBuilder->when(count($this->filterStatuses) > 0, function ($query) {
        //     $query->whereIn('task_status_id', $this->filterStatuses);
        // });

        // $tasks = \DB::select("
        //     WITH RECURSIVE task_hierarchy AS (
        //         SELECT id, list_order, parent 
        //         FROM tasks WHERE parent = ?
        //         UNION ALL
        //         SELECT t.id, t.list_order, t.parent FROM tasks t
        //         INNER JOIN task_hierarchy th ON t.parent = th.id
        //     )
        //     SELECT * FROM task_hierarchy
        //     ORDER BY list_order
        // ", [$this->fPhase]);

        // return collect($tasks);
        return Task::where('parent', $this->fPhase)
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

    public function render()
    {
        $this->statuses = TaskStatus::all();
        $this->phases = Task::whereNull('parent')->get();
        
        return view('livewire.partials.tasks.header');
    }
}
