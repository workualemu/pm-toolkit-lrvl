<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;

class Tasks extends Component
{
    public $tasks = [];

    public $project;

    public $sidebarFilter = [];

    public $filterParams = [];

    public function onGanttTaskDrag($taskId, $mode, $task, $original)
    {
        // TODO
    }
   
    public function addNewPhase()
    {
        $user =  Auth::user();
        $projectId = $user->project_id;
        $project = Project::find($projectId);

        $this->dispatch('openTaskRightPopup', 0, 0, 0);
        // $this->showTaskRightPopup = true;
    }

    #[On('filterTasksWithHeader')]
    public function filterTasksWithHeader($filterParams)
    {
        $this->removeSidebarFilters();
        $user =  Auth::user();
        $sidebarFilter = [['type'=>'where','column'=>'project_id', 'value'=>$user->project_id]];

        $this->filterParams = $filterParams; 
        $this->filterParams['sidebarFilter'] = $sidebarFilter;

        $this->getTasks();
    }

    #[On('filterTasksWithSidebar')]
    public function filterTasksWithSidebar($condition)
    {
        $this->dispatch('resetHeaderCriteria');
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

        $this->getTasks();
    }

    #[On('filterByAssignee')]
    public function onFilterByAssignee($assignedTo)
    {
        $this->resetParams();
        $this->filterParams['fAssignee'] = $assignedTo;

        $this->getTasks();

    }

    #[On('filterByStatus')]
    public function onFilterByStatus($statusId)
    {
        $this->resetParams();
        $this->filterParams['fStatus'] = [$statusId=>true];

        $this->getTasks();

    }

    #[On('filterByPriority')]
    public function onFilterByPriority($priorityId)
    {
        $this->resetParams();
        $this->filterParams['fPriority'] = $priorityId;
        $this->getTasks();
    }

    #[On('filterByTag')]
    public function onFilterByTag($tagId)
    {
        $this->resetParams();
        $tasks = \DB::table('tag_tasks')
            ->where('tag_id', '=', $tagId)
            ->get();

        $taggedTasks = $tasks->pluck('task_id')->toArray();
        $this->filterParams['fTaskIds'] = $taggedTasks;
        $this->getTasks();
    }

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

    public function removeSidebarFilters()
    {
        $this->dispatch('removeSidebarFilters');
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

        $this->resetParams();
        $condition = ['type'=>'where','column'=>'assigned_to', 'value'=>Auth::user()->id] ;
        $this->filterTasksWithSidebar($condition);
    }

    public function render()
    {
        return view('livewire.tasks', [
            'taskIds' => collect($this->tasks)->pluck('id')->join('-'),
        ]);
    }

    //-------------------------Private ------------------

    private function getTasks()
    {
        $newTasks = $this->executeQuery();
        $existingTaskIds = collect($this->tasks)->pluck('id');

        foreach ($newTasks as $newTask) {
            if (!$existingTaskIds->contains($newTask->id)) {
                $this->tasks[] = $newTask; 
            }
        }

        $this->tasks = collect($this->tasks)->whereIn('id', $newTasks->pluck('id'))->values()->sortBy('path')->all(); 
        // $this->tasks = collect($this->tasks)->orderBy('path'); 
    }

    private function executeQuery()
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
