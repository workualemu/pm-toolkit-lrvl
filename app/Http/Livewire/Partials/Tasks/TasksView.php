<?php

namespace App\Http\Livewire\Partials\Tasks;

use Livewire\Component;
use App\Models\Task;

class TasksView extends Component
{

    public $tasks;
    public $filterParams = [];

    protected $hasGeneratedTasks = false;

    protected $listeners = [
        'taskListUpdated' => 'onUpdateTaskList',
        'resetParams' => 'onResetParams',
        'filter-by-status' => 'onFilterByStatus',
    ];

    public function onUpdateTaskList($filterParams)
    {
        $this->filterParams = $filterParams;
        $this->tasks = $this->getTasks();
    }

    public function onResetParams($filterParams)
    {
        $this->onUpdateTaskList($filterParams);
    }

    public function onFilterByStatus($status)
    {
        $this->filterParams['fStatus'] = [$status];
        $this->onUpdateTaskList($this->filterParams);
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
            array_push($criteria, ['type' => 'where', 'column' => 'planned_end_date', 'operator'=> '>=', 'value' => $this->filterParams['fDateFrom']]);
                
        }
        return Task::sortedTasks($criteria, 'path', 'asc', $this->filterParams['fPhase']);
            
    }
            

}
