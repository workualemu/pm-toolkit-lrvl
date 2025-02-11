<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;
use Livewire\Livewire;
use Livewire\Attributes\On;

use Livewire\Attributes\Reactive;

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
        $this->task->refresh();
    }

    public function openModal($parentId, $taskId, $taskLevel)
    {
        $this->dispatch('openTaskModal', $parentId, $taskId, $taskLevel);
        $this->dispatch('setTaskId', $taskId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function addNewTask($parentId, $taskLevel)
    {
        $this->openModal($parentId, 0, $taskLevel);
    }

    // public function storeTask($task)
    // {
    //     // $this->reset(['title']);
    //     $this->showModal = false;
    // }

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

    // public function filterByStatus($status_id)
    // {
    //     $this->dispatch('filterByStatus', $status_id);
    // }

    // public function filterByPriority($priority)
    // {
    //     $this->dispatch('filter-by-priority', $priority);
    // }

    public function filterByTag($tag)
    {
        $this->dispatch('filterByTag', $tag);
    }

    // public function filterByAssignee($assignee)
    // {
    //     $this->dispatch('filter-by-assignee', $assignee);
    // }

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
        
        // return view('livewire.task-component');
        return view('livewire.task-component')->with([
            'styles' => $this->getTaskStyles(),
        ]);
    }
}
