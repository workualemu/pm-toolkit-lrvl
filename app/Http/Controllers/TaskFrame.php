<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Config;
use Illuminate\Notifications\DatabaseNotification;

class TaskFrame extends Controller
{
    public function getTasks(int $project_id)
    {
        $user =  Auth::user();
        if($project_id > 0) {
            $user->project_id = $project_id;
            $user->save();
        }
        $project = Project::find($project_id);

        $tasks = Task::all();


        return view('pages/task-frame', compact('tasks', 'project'));
    }

    public function filterTasksWithSidebar()
    {
        $condition = request()->query();
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

        $user =  Auth::user();
        $project = Project::find($user->project_id);
        $tasks = $this->executeQuery();
        return view('pages/task-frame', compact('tasks', 'project'));
    }

    public function executeQuery()
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
