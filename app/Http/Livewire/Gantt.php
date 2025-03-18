<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use App\Traits\TaskTrait;

class Gantt extends Component
{
    public $project;
    public $searchValue = [];
    public $data ='';
    public $tasks;
    public $dragEnded = false;
    public $moveToIndex = -1;
    public $moveToParent = -1;
    public $searchTerm = '';
    public $project_title;
    public $page_title = 'Gantt chart';


    public function updatedSearchTerm()
    {
        $this->dispatch('$refresh');
    }

    #[On('ganttTaskAdded')]
    public function onTaskAdd($task)
    {
        $user =  Auth::user();
        $projectId = $user->project_id;
        $this->project = Project::find($projectId);

        $type = 'task';
        if($task['$level'] == 0) {
            $type = 'project';
        }
        $task = Task::create([
            'project_id' => $user->project_id,
            'user_id' => $user->id,
            'title' => $task['text'],
            'start_date' => $task['start_date'],
            'duration' => $task['duration'],
            'parent' => $task['parent'],
            'task_status_id' => 1,
            'text' => $task['text'],
            'description' => $task['text'],
            'type' => $type,
            'progress' => $task['progress'],
            'level' => $task['$level']
        ]);

    }

    #[On('ganttTaskDragged')]
    public function onTaskDragged($id, $mode, $task)
    {
        
        // $dt = $this->tasks->keyBy('id');
        $dTask = Task::find($task['id']);
        $dTask->start_date = $task['start_date'];
        $dTask->duration = isset($task['duration']) ? (int)$task['duration'] : 0;
        $dTask->progress = $task['progress'];
        $dTask->end_date = \Carbon\Carbon::parse($dTask->start_date)->addDays($dTask->duration);
        $dTask->save();
        // $this->dispatch('ganttTaskUpdated', $this->project->id);
       
        

        // $parent_id = $dTask->parent;
        // while($parent_id != null) {
        //     $parent = Task::find($parent_id);
        //     if($parent->start_date > $dTask->start_date) {
        //         $parent->start_date = $dTask->start_date;
        //     }
        //     if($parent->end_date < $dTask->end_date) {
        //         $parent->end_date = $dTask->end_date;
        //     }
        //     $to = \Carbon\Carbon::parse($parent->end_date);
        //     $from = \Carbon\Carbon::parse($parent->start_date);
        //     $parent->duration =$to->diffInDays($from);
        //     $parent->save();
        //     $parent_id = $parent->parent;
        // }
    }

    #[On('ganttTaskUpdated')]
    public function onTaskUpdated($id, $task)
    {
        $parent_id = $task['parent']==0?null:$task['parent'];
        $task = Task::updateOrCreate(
            ['id' => $task['id']],
            [
            'title' => $task['text'],
            'start_date' => $task['start_date'],
            'end_date' => \Carbon\Carbon::parse($task['start_date'])->addDays($task['duration']),
            'duration' => $task['duration'],
            'parent' => $task['parent']==0?null:$task['parent'],
            'task_status_id' => 1,
            'text' => $task['text'],
            'description' => $task['text'],
            'type' => $task['$rendered_type'],
            'progress' => $task['progress'],
            'level' => $task['$level']
        ]
        );
        $this->dispatch('$refresh');

    }

    #[On('ganttTaskDeleted')]
    public function onTaskDeleted($id)
    {
        $res=Task::where('id', $id)->delete();
        $this->dispatch('$refresh');
    }

    #[On('ganttLinkAdded')]
    public function onLinkAdd($id, $item)
    {
        Link::updateOrCreate(
            ['source' => $item['source'], 'target' => $item['target']],
            ['type' => $item['type']]
        );
        $this->dispatch('$refresh');
    }

    #[On('ganttLinkDeleted')]
    public function onLinkDeleted($id, $item)
    {
        $res=Link::where('id', $id)->delete();
    }

    #[On('ganttTaskVerticalMoved')]
    public function onAfterTaskMove($id, $parent, $tindex)
    {
        // these variables are used to avoid repetitive calls during mouse drag.
        // refer onBeforeRowDraggedEnd() method
        $this->moveToIndex = $tindex;  
        $this->moveToParent = $parent;
    }

    #[On('ganttBeforeRowDragEnd')]
    public function onBeforeRowDraggedEnd($id, $parent, $tindex)
    {
        $tasks = Task::filterByParent($this->moveToParent);

        $rank = 0;
        $task = Task::find($id);
        $task->parent = $this->moveToParent;
        $task->list_order = $this->moveToIndex;
        $task->save();

        foreach($tasks as $ts){
            if($rank == $this->moveToIndex){
                $rank += 1;
                $ts->list_order = $rank;
                $ts->save();
                $rank += 1;
                continue;
            }
            if($ts->id == $task->id) {
                continue;
            } 
            
            $ts->list_order = $rank;
            $ts->save();
            $rank += 1;
        }

        $this->moveToIndex = -1;  
        $this->moveToParent = -1;
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
    }

    public function render()
    {
        // $tasks = Task::where($this->searchValue)->orderBy('list_order', 'asc')->get();
        // $links = new Link();

        // /**
        //  * @TBD to be refactored for searching. Searching to be implemented from the API
        //  */

        // $this->tasks = Task::where($this->searchValue)->get()->sortBy('list_sort');

        // $ldata = response()->json([
        //     "tasks" => $tasks->all(),
        //     "links" => $links->all()
        // ]);

        $this->project_title = $this->project->title;
        return view('livewire.gantt');
    }
}
