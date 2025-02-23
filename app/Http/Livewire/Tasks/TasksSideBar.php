<?php

namespace App\Http\Livewire\Tasks;

use Livewire\Component;
use App\Models\TaskPriority;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class TasksSideBar extends Component
{
    public $highlight = "bg-blue-300";
    public $bgAll = "";
    public $bgMyAssigned = "bg-blue-300";
    public $bgMyCommented = "";
    public $bgMyReporting = "";
    public $bgStarred = "";
    public $taskPriorities = [];

    #[On('removeSidebarFilters')]
    public function onRemoveSidebarFilters()
    {
        $this->bgAll = $this->highlight;
        $this->bgMyAssigned = "";
        $this->bgMyCommented = "";
        $this->bgMyReporting = "";
        $this->bgStarred = "";

        $this->dispatch('$refresh');
    }
    public function allTasks()
    {

        $this->bgAll = $this->highlight;
        $this->bgMyAssigned = "";
        $this->bgMyCommented = "";
        $this->bgMyReporting = "";
        $this->bgStarred = "";

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

    public function mount()
    {
        $this->taskPriorities = TaskPriority::all()->sortBy('id');
    }

    public function render()
    {
        return view('livewire.tasks.tasks-side-bar');
    }

}
