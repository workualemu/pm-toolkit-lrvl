<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TaskPriority;
use Illuminate\Support\Facades\Auth;

class TasksSideBar extends Component
{
    // public $queryItem = [
    //     'allTasks'=> ['method'=>'showAllTasks', ]
    // ]
    public $highlight = "bg-primary/10";
    public $bgAll = "bg-primary/10";
    public $bgMyAssigned = "";
    public $bgMyCommented = "";
    public $bgMyReporting = "";
    public $bgStarred = "";
    public $taskPriorities = [];

    public $priorityCondition = [];
    public $filterCondition = [];



    public function allTasks()
    {

        $this->bgAll = $this->highlight;
        $this->bgMyAssigned = "";
        $this->bgMyCommented = "";
        $this->bgMyReporting = "";
        $this->bgStarred = "";

        $this->filterCondition = [];
        $this->priorityCondition = [];
        // return redirect()->route('sidebar-filter', []);
        $this->dispatch('filterTasksWithSidebar', []);

    }

    public function myAssignedTasks()
    {
        $this->bgAll = "";
        $this->bgMyAssigned = $this->highlight;
        $this->bgMyCommented = "";
        $this->bgMyReporting = "";
        $this->bgStarred = "";

        $condition = ['type'=>'where','column'=>'assigned_to', 'value'=>Auth::user()->id] ;

        $this->dispatch('filterTasksWithSidebar', $condition);
    }

    public function filterTasksByPriority($priority_id)
    {
        $this->bgAll = "";
        $this->bgMyAssigned = $this->highlight;
        $this->bgMyCommented = "";
        $this->bgMyReporting = "";
        $this->bgStarred = "";

        $this->priorityCondition = ['task_priority_id', $priority_id];
        $searchCondition = [$this->priorityCondition];
        if(!empty($this->filterCondition)) {
            array_push($searchCondition, $this->filterCondition);
        }

        $this->dispatch('filterTasks', $searchCondition);
    }

    public function myCommentedTasks()
    {
        $this->bgAll = "";
        $this->bgMyAssigned = "";
        $this->bgMyCommented = $this->highlight;
        $this->bgMyReporting = "";
        $this->bgStarred = "";

        $tasks = \DB::table('comments')
            ->where('commentable_type', '=', 'App\Models\Task')
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        $tasks = $tasks->pluck('commentable_id');

        $condition = ['type'=>'whereIn','column'=>'id', 'values'=>$tasks] ;

        $this->dispatch('filterTasksWithSidebar', $condition);

    }

    public function myReportingTasks()
    {
        
        $this->bgAll = "";
        $this->bgMyAssigned = "";
        $this->bgMyCommented = "";
        $this->bgMyReporting = $this->highlight;
        $this->bgStarred = "";

        $condition = ['type'=>'where', 'column'=>'report_by', 'value'=>Auth::user()->id] ;
        
        $this->dispatch('filterTasksWithSidebar', $condition);
    }

    public function starredTasks()
    {
        $this->bgAll = "";
        $this->bgMyAssigned = "";
        $this->bgMyCommented = "";
        $this->bgMyReporting = "";
        $this->bgStarred = $this->highlight;

        $condition = ['type'=>'where', 'column'=>'is_starred', 'value'=>true] ;
        
        $this->dispatch('filterTasksWithSidebar', $condition);
    }

    // public function addNewTask()
    // {
    //     $this->dispatch('openTaskModal', null);
    // }

    public function mount()
    {
        $this->taskPriorities = TaskPriority::all()->sortBy('id');
    }

    public function render()
    {
        return view('livewire.tasks-side-bar');
    }

}
