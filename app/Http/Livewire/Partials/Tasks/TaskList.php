<?php

namespace App\Http\Livewire\Partials\Tasks;

use Livewire\Component;
use App\Models\Task;

class TaskList extends Component
{

    public $tasks;
    public $filterStatuses = [];
    public $filterParams = [];
    protected $hasGeneratedTasks = false;

    protected $listeners = [
        'taskListUpdated' => 'onUpdateTaskList',
    ];

    public function onUpdateTaskList($filterParams)
    {
        $this->filterParams = $filterParams;
        $this->tasks = $this->getTasks();
    }

    public function mount($filterParams)
    {
        $this->filterParams = $filterParams;
    }
    

    public function getTasks()
    {
        $clause = [];
        if (!empty($this->filterParams['searchTerm'])) {
            $clause = [['title', 'Like', '%'.$this->filterParams['searchTerm'].'%']];
        }
        $clause = array_merge($this->filterParams['searchValue'], $clause);

        logger($this->filterParams);
        if (!empty($this->selectedStatuses)) {
            $query->whereIn('task_status_id', $this->selectedStatuses);
        }

        $qBuilder = Task::query();

        if (empty($this->filterParams['fPhase'])) {
            $qBuilder = $qBuilder->whereNull('parent');
        } else {
            $qBuilder = $qBuilder->where('id', $this->filterParams['fPhase']);
        }

        $fStatus = $this->filterParams['fStatus'];
        
        foreach($this->filterParams['fStatus'] as $key => $value){
            if($value){
                $clause = array_merge($clause, [['task_status_id', $key]]);
            }
        }
        return $qBuilder
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
        if (!$this->hasGeneratedTasks) {
            $this->tasks = $this->getTasks();
            $this->hasGeneratedTasks = true;
        }
        return view('livewire.partials.tasks.task-list');
    }
}
