<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use App\Traits\TaskTrait;

class KanbanBoard extends Component
{
    use TaskTrait;
    public $project;
    public $searchValue = [];
    public $statuses;


    #[On('updateTaskOrder')]
    public function updateTaskOrder($order, $status)
    {
        $statusM = TaskStatus::find($status);
        foreach ($order as $index => $taskId) {
            Task::where('id', $taskId)->update([
                'kanban_list_rank' => $index + 1,
                'task_status_id' => $status
            ]);
        }

        // $this->tasks = Task::orderBy('kanban_list_rank')->get(); 
    }

    #[On('filterTasksWithHeader')]
    public function filterTasksWithHeader($filterParams)
    {
        $user =  Auth::user();
        $sidebarFilter = [
                    ['type'=>'where','column'=>'project_id', 'value'=>$user->project_id],
                    ['type'=>'where','column'=>'level', 'value'=>2]
                ];

         
        $filterParams['sidebarFilter'] = $sidebarFilter;
        $this->tasks = $this->filterTasks($filterParams, 'kanban_list_rank');

        $this->filterParams = $filterParams;
        $this->dispatch('$refresh');
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

        $this->searchValue = array_merge([['project_id', $user->project_id]], $this->searchValue);

        $this->tasks = Task::where($this->searchValue)
                            ->where('level', 2)->orderBy('kanban_list_rank')->get();
        $this->statuses = TaskStatus::where($this->searchValue)->orderBy('kanban_list_rank')->get();
    }

    public function render()
    {
        return view('livewire.kanban-board', [
            'taskIds' => collect($this->tasks)->pluck('id')->join('-'),
        ]);
    }


}
