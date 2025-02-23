<?php

namespace App\Http\Livewire\Tasks;

use Livewire\Component;
use App\Models\Task;
use Livewire\Attributes\On;

class TasksView extends Component
{

    
    public $tasks;

    public $filterParams = [];

    protected $hasGeneratedTasks = false;

    // protected $listeners = [
    //     'task-list-updated' => 'onUpdateTaskList',
    //     'resetParams' => 'onResetParams',
    //     'filter-by-status' => 'onFilterByStatus',
    //     'filter-by-tag' => 'onFilterByTag',
    //     'filter-by-priority' => 'onFilterByPriority',
    //     'filter-by-assignee' => 'onFilterByAssignee',
    // ];

    #[On('task-list-updated')]
    public function onUpdateTaskList($filterParams)
    {
        $this->filterParams = $filterParams;
        $this->tasks = $this->getTasks();
    }

    #[On('resetParams')]
    public function onResetParams($filterParams)
    {
        $this->onUpdateTaskList($filterParams);
    }

    // #[On('filter-by-status')]
    // public function onFilterByStatus($filterValue)
    // {
    //     $this->resetParams();
    //     $this->filterParams['fStatus'] = [$filterValue=>true];
    //     $this->tasks = $this->getTasks();
    // }

    // #[On('filter-by-priority')]
    // public function onFilterByPriority($filterValue)
    // {
    //     $this->resetParams();
    //     $this->filterParams['fPriority'] = $filterValue;
    //     $this->tasks = $this->getTasks();
    // }

    // #[On('filter-by-assigneetempo')]
    // public function onFilterByAssignee($filterValue)
    // {
    //     logger('filtertempo');
    //     $this->resetParams();
    //     $this->tasks = [];
    //     usleep(100000); 
    //     $this->filterParams['fAssignee'] = $filterValue;
    //     $filteredTasks = $this->getTasks();
    //     $this->tasks = $filteredTasks->isEmpty() ? [] : $filteredTasks->toArray();
    // }

    // #[On('filter-by-tag')]
    // public function onFilterByTag($filterValue)
    // {
    //     $this->resetParams();
    //     $tasks = \DB::table('tag_tasks')
    //         ->where('tag_id', '=', $filterValue)
    //         ->get();

    //     $taggedTasks = $tasks->pluck('task_id')->toArray();
    //     $this->filterParams['fTaskIds'] = $taggedTasks;
    //     $this->tasks = $this->getTasks();
    // }

    public function resetParams()
    {
        $user =  \Auth::user();
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
    }
    
    public function getTasks()
    {
        $criteria = [];

        if ($this->filterParams['sidebarFilter'] != null) {
            foreach ($this->filterParams['sidebarFilter'] as  $condition) {
                    array_push($criteria, $condition);
            }
        }

        if ($this->filterParams['searchTerm'] != null) {
            array_push($criteria, ['type' => 'whereRaw', 'column' => 'LOWER(tasks.title) LIKE ? OR LOWER(tasks.description) LIKE ?', 
                'values' => ['%' . strtolower($this->filterParams['searchTerm']) . '%',
                             '%' . strtolower($this->filterParams['searchTerm']) . '%'
                        ]]);
        }

        if ($this->filterParams['fTitle'] != null) {
            array_push($criteria, ['type' => 'whereRaw', 'column' => 'LOWER(tasks.title) LIKE ?', 
                'values' => ['%' . strtolower($this->filterParams['fTitle']) . '%']]);
        }
        
        $fStatus = array_filter(
            $this->filterParams['fStatus'],
            fn($value, $key) => $value, 
            ARRAY_FILTER_USE_BOTH
        );
        
        if (!empty($fStatus)) {
            array_push($criteria, ['type' => 'whereIn', 'column' => 'task_status_id', 'values' => array_keys($fStatus)]);
        }
        
        if ($this->filterParams['fDateFrom'] != null) {
            array_push($criteria, ['type' => 'where', 'column' => 'end_date', 'operator'=> '>=', 'value' => $this->filterParams['fDateFrom']]);
                
        }

        if ($this->filterParams['fDateTo'] != null) {
            array_push($criteria, ['type' => 'where', 'column' => 'end_date', 'operator'=> '<=', 'value' => $this->filterParams['fDateTo']]);
                
        }

        if ($this->filterParams['fPriority'] != null) {
            array_push($criteria, ['type' => 'where', 'column' => 'task_priority_id', 'value' => $this->filterParams['fPriority']]);  
        }

        if ($this->filterParams['fAssignee'] != null) {
            array_push($criteria, ['type' => 'where', 'column' => 'assigned_to', 'value' => $this->filterParams['fAssignee']]);  
        }

        if ($this->filterParams['fTaskIds'] != null) {
            array_push($criteria, ['type' => 'whereIn', 'column' => 'id', 'values' => $this->filterParams['fTaskIds']]);  
        }

        return Task::sortedTasks($criteria, 'path', 'asc', $this->filterParams['fPhase']);   
    }
}
