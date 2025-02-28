<?php

namespace App\Http\Livewire\Tasks;

use Livewire\Component;
use App\Models\Task;
use App\Models\TaskPriority;
use Livewire\Livewire;
use Livewire\Attributes\On;

class TaskComponent extends Component
{
    public $showModal = false;
    
    public Task $task;
    public $task_id = 0;
    public $isStarred = false;
    public $taskStatus;
    public $assignedTo;
    public $taskPriority;
    public $taskTags;

    // protected $listeners = [
    //     'refreshTaskComponent' => 'onRefreshThisTask',
    // ];

    #[On('refreshTaskComponent.{task.id}')] 
    public function onRefreshThisTask()
    {
        
        if ($this->task) {
            $this->task->refresh(); // Ensures Livewire tracks changes
            $this->taskStatus = $this->task->getTaskStatus();
            $this->assignedTo = $this->task->getAssignedTo();
            $this->taskPriority = $this->task->getTaskPriority();
            $this->taskTags = $this->task->getTaskTags();
            $this->isStarred = $this->task->is_starred;

            $this->dispatch('$refresh'); 
        }

        if($this->task->getParent){
            $this->dispatch('refreshTaskComponent.'.$this->task->getParent->id);
        }
    }

    public function addNewTask($parentId, $taskLevel)
    {
        $this->openModal($parentId, 0, $taskLevel);
    }

    public function openModal($parentId, $taskId, $taskLevel)
    {
        $this->dispatch('openTaskRightPopup', $parentId, $taskId, $taskLevel);
        // $this->dispatch('setTaskId', $taskId);
        // $this->showModal = true;
    }



    public function mount($task)
    {
        $this->task = $task ? $task : new Task();
        $this->taskStatus = $task->getTaskStatus();
        $this->assignedTo = $task->getAssignedTo();
        $this->taskPriority = $task->getTaskPriority();
        $this->taskTags = $task->getTaskTags();
        $this->isStarred = $task->is_starred;
    }

    public function setStarred()
    {
        $this->task->is_starred = $this->isStarred;
        $this->task->save();
    }

    public function filterByTag($tag)
    {
        $this->dispatch('filterByTag', $tag);
    }

    public function getTaskStyles(): array
    {
        if (!isset($this->task) || !isset($this->task->level)) {
            return ['padding' => 'pl-2', 'bgColor' => 'bg-gray-100']; // Default styling if task is not set
        }

        return match ($this->task->level) {
            0 => ['padding' => 'pl-2', 'bgColor' => 'bg-blue-200'],
            1 => ['padding' => 'pl-4', 'bgColor' => 'bg-blue-50'],
            default => ['padding' => 'pl-6', 'bgColor' => 'white'],
        };
    }

    public function render()
    {
        return view('livewire.tasks.task-component')->with([
            'styles' => $this->getTaskStyles(),
        ]);
    }
}
