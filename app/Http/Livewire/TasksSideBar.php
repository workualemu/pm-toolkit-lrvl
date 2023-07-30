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
    public $bgDeleted = "";
    public $taskPriorities = [];

    public $priorityCondition = [];
    public $filterCondition = [];



    public function allTasks()
    {

        $this->bgAll = $this->highlight;
        $this->bgMyAssigned = "";
        $this->bgMyCommented = "";
        $this->bgMyReporting = "";
        $this->bgDeleted = "";

        $this->filterCondition = [];
        $this->priorityCondition = [];
        $this->emit('filterTasks', []);

    }

    public function myAssignedTasks()
    {
        $this->bgAll = "";
        $this->bgMyAssigned = $this->highlight;
        $this->bgMyCommented = "";
        $this->bgMyReporting = "";
        $this->bgDeleted = "";

        $this->filterCondition = ['assigned_to',Auth::user()->id];
        $searchCondition = [$this->filterCondition];
        if(!empty($this->priorityCondition)) {
            array_push($searchCondition, $this->priorityCondition);
        }

        $this->emit('filterTasks', $searchCondition);
    }

    public function filterTasksByPriority($priority_id)
    {
        $this->bgAll = "";
        $this->bgMyAssigned = $this->highlight;
        $this->bgMyCommented = "";
        $this->bgMyReporting = "";
        $this->bgDeleted = "";

        $this->priorityCondition = ['task_priority_id', $priority_id];
        $searchCondition = [$this->priorityCondition];
        if(!empty($this->filterCondition)) {
            array_push($searchCondition, $this->filterCondition);
        }

        $this->emit('filterTasks', $searchCondition);
    }

    public function myCommentedTasks()
    {
        $this->bgAll = "";
        $this->bgMyAssigned = "";
        $this->bgMyCommented = $this->highlight;
        $this->bgMyReporting = "";
        $this->bgDeleted = "";

        $this->filterCondition = ['assigned_to',Auth::user()->id];
        $searchCondition = [$this->filterCondition];
        if(!empty($this->priorityCondition)) {
            array_push($searchCondition, $this->priorityCondition);
        }

        $this->emit('filterTasks', $searchCondition);
    }

    public function myReportingTasks()
    {
        $this->bgAll = "";
        $this->bgMyAssigned = "";
        $this->bgMyCommented = "";
        $this->bgMyReporting = $this->highlight;
        $this->bgDeleted = "";

        $this->filterCondition = ['assigned_to',Auth::user()->id];
        $searchCondition = [$this->filterCondition];
        if(!empty($this->priorityCondition)) {
            array_push($searchCondition, $this->priorityCondition);
        }

        $this->emit('filterTasks', $searchCondition);
    }

    public function deletedTasks()
    {
        $this->bgAll = "";
        $this->bgMyAssigned = "";
        $this->bgMyCommented = "";
        $this->bgMyReporting = "";
        $this->bgDeleted = $this->highlight;

        $this->filterCondition = ['assigned_to',Auth::user()->id];
        $this->emit('showMyAssignedTasks', null);
    }

    public function addNewTask()
    {
        $this->emit('openTaskModal', null);
    }

    public function mount()
    {
        $this->taskPriorities = TaskPriority::all()->sortBy('id');
    }

    public function render()
    {
        return view('livewire.tasks-side-bar');
    }

}
