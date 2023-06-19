<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use App\Models\Tag;
use App\Models\TagTask;
use Illuminate\Support\Facades\Auth;

class TaskRightPopup extends Component
{
    public $showModal = false;
    public Task $task;
    public $taskPriorities = [];
    public $taskStatuses = [];
    public $tags = [];
    public TagTask $tagTasks;

    protected $rules = [
        'task.title' => 'required|min:2',
        'task.user_id' => 'required',
        'task.planned_end_date'=>'',
        'task.task_priority_id'=>'required',
        'task.task_status_id'=>'required',
        'tagTasks.tag_id'=>'',
    ];
    protected $listeners = ['openTaskModal' => 'openModal'];

    public function openModal($task_id)
    {
        $this->tagTasks = new TagTask();
        $this->task = new Task();
        if($task_id > 0){
            $this->task = Task::find($task_id);
        }

        $this->taskPriorities = TaskPriority::all();
        $this->taskStatuses = TaskStatus::all();
        $this->tags = Tag::all();

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function store()
    {

        $user = Auth::user();
        $this->task->user_id = $user->id;
        $this->task->project_id = $user->project_id;
        $this->task->save();
        // dd($this->tagTasks->toArray()['tag_id']);
        // ->pluck('id')->toArray(); 
        // $this->task->tags()->attach($this->tagTasks->toArray()['tag_id']);
        $this->task->refresh();

        $this->showModal = false;
        $this->emit('refreshTasks');
        
    }

    public function mount()
    {
        $this->modalTask = new Task();
    }

    public function render()
    {
        return view('livewire.task-right-popup');
    }
    
}
