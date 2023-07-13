<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use App\Models\Link;
use Illuminate\Support\Facades\Auth;

class Gantt extends Component
{
    public $project;
    public $searchValue = [];
    public $data;

    protected $listeners = ['gantt-task-dragged' => 'taskDragged'];

    public function taskDragged($task_id, $mode, $task)
    {
        $dt = $this->tasks->keyBy('id');

        // dd($task);
        // $dt[$task['id']]->text = 'zzzzzzzzzz';
        $dTask = Task::find($task['id']);
        $dTask->start_date = $task['start_date'];
        $dTask->duration = $task['duration'];
        $dTask->progress = $task['progress'];
        $dTask->planned_end_date = $dTask->start_date->addDays($dTask->duration);
        $dTask->save();
        $parent_id = $dTask->parent;
        while($parent_id != null){
            $parent = Task::find($parent_id);
            if($parent->start_date > $dTask->start_date){
                $parent->start_date = $dTask->start_date;
            }
            if($parent->planned_end_date < $dTask->planned_end_date){
                $parent->planned_end_date = $dTask->planned_end_date;
            }
            $to = \Carbon\Carbon::parse($parent->planned_end_date);
            $from = \Carbon\Carbon::parse($parent->start_date);
            $parent->duration =$to->diffInDays($from);
            $parent->save();
            $parent_id = $parent->parent;
        }
        // dd($dTask);
    }

    public function mount($project_id)
    {
        $user =  Auth::user();
        if($project_id > 0){
            $user->project_id = $project_id;
            $user->save();
        }
        $projectId = $user->project_id;
        $this->project = Project::find($projectId);
        
        $this->searchValue = array_merge([['project_id', $user->project_id]], $this->searchValue);
    }

    public function render()
    {
        $tasks = Task::where($this->searchValue )->get();
        $links = new Link();

        // return response()->json([
        //     "tasks" => $tasks->all(), 
        //     "links" => $links->all()
        // ]);

        $ldata = response()->json([
            "tasks" => $tasks->all(), 
            "links" => $links->all()
        ]);

        $this->data = $ldata;
// dd(json_decode($ldata));
        return view('livewire.gantt');
    }
}
