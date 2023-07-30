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
    public $data ='';
    public $tasks;

    protected $listeners = ['gantt-task-added' => 'onTaskAdd',
                            'gantt-task-dragged' => 'onTaskDragged',
                            'gantt-task-deleted' => 'onTaskDeleted',
                            'gantt-task-updated' => 'onTaskUpdated',
                            'gantt-link-added' => 'onLinkAdd',
                            'gantt-link-deleted' => 'onLinkDeleted',
                            'gantt-task-vertical_moved' => 'onTaskMove'
                            ];

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

    public function onTaskDragged($task_id, $mode, $task)
    {
        $dt = $this->tasks->keyBy('id');

        $dTask = Task::find($task['id']);
        $dTask->start_date = $task['start_date'];
        $dTask->duration = $task['duration'];
        $dTask->progress = $task['progress'];
        $dTask->planned_end_date = $dTask->start_date->addDays($dTask->duration);
        $dTask->save();
        $parent_id = $dTask->parent;
        while($parent_id != null) {
            $parent = Task::find($parent_id);
            if($parent->start_date > $dTask->start_date) {
                $parent->start_date = $dTask->start_date;
            }
            if($parent->planned_end_date < $dTask->planned_end_date) {
                $parent->planned_end_date = $dTask->planned_end_date;
            }
            $to = \Carbon\Carbon::parse($parent->planned_end_date);
            $from = \Carbon\Carbon::parse($parent->start_date);
            $parent->duration =$to->diffInDays($from);
            $parent->save();
            $parent_id = $parent->parent;
        }
    }

    public function onTaskUpdated($id, $task)
    {
        $task = Task::updateOrCreate(
            ['id' => $task['id']],
            [
            'title' => $task['text'],
            'start_date' => $task['start_date'],
            'duration' => $task['duration'],
            'parent' => $task['parent'],
            'task_status_id' => 1,
            'text' => $task['text'],
            'description' => $task['text'],
            'type' => $task['$rendered_type'],
            'progress' => $task['progress'],
            'level' => $task['$level']
        ]
        );

    }

    public function onTaskDeleted($id)
    {
        $res=Task::where('id', $id)->delete();
    }

    public function onLinkAdd($id, $item)
    {
        Link::updateOrCreate(
            ['source' => $item['source'], 'target' => $item['target']],
            ['type' => $item['type']]
        );
    }

    public function onLinkDeleted($id, $item)
    {
        $res=Link::where('id', $id)->delete();
    }

    public function onTaskMove($id, $parent, $tindex)
    {
        $task = Task::find($id);
        $task->parent = $parent;
        $task->save();
    }

    public function mount($project_id)
    {
        $user =  Auth::user();
        if($project_id > 0) {
            $user->project_id = $project_id;
            $user->save();
        }
        $projectId = $user->project_id;
        $this->project = Project::find($projectId);

        $this->searchValue = array_merge([['project_id', $user->project_id]], $this->searchValue);
    }

    public function render()
    {
        $tasks = Task::where($this->searchValue)->get();
        $links = new Link();

        $this->tasks = Task::where($this->searchValue)->get();

        $ldata = response()->json([
            "tasks" => $tasks->all(),
            "links" => $links->all()
        ]);

        $this->data = $ldata->content();
        return view('livewire.gantt');
    }
}
