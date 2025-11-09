<?php

namespace App\Http\Livewire\Tasks;

use App\Models\File;
use App\Models\Project;
use App\Models\Tag;
use App\Models\TagTask;
use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Notifications\TaskAssignment;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule as LivewireRule;
use App\Http\Livewire\Tasks\Tasks;

class TaskRightPopup extends Component
{
    use WithFileUploads;

    public $project;
    public $showTaskRightPopup = false;
    public Task $task;
    public $taskPriorities = [];
    public $taskStatuses = [];
    public $tags = [];
    public $taskTags = [];
    public $users = [];
    public $taskLevel = -1;
    public $taskParent = -1;
    public $formTitle = '';

    public $datePickerDisabled = '';

    #[LivewireRule('required|string|min:5')] 
    public $title = '';

    public $start_date = '';
    public $end_date = '';
    public $assigned_to = 0;
    public $report_by = 0;
    public $description = '';
    public $task_priority_id = 0;
    public $task_status_id = 0;
    #[LivewireRule('numeric|min:0|max:100')]
    public $progress = 0;

    private function getFormTitle()
    {
        $titles = [
            0 => ['edit' => 'Edit phase', 'new' => 'New phase'],
            1 => ['edit' => 'Edit activity', 'new' => 'New activity'],
            2 => ['edit' => 'Edit task', 'new' => 'New task'],
        ];
    
        $isEditing = $this->task?->id > 0;
        $level = $isEditing ? $this->task->level : $this->taskLevel;
    
        $this->formTitle = $titles[$level][$isEditing ? 'edit' : 'new'] ?? ($isEditing ? 'Edit ' : 'Add ');
    }

    #[On('openTaskRightPopup')]
    public function openTaskRightPopup($parentId, $taskId, $taskLevel)
    {
        $this->taskLevel = $taskLevel;
        $this->taskParent = $parentId;

        $attachments = File::filterByTask($taskId)->get();
        
        if($taskId > 0) {
            $this->task = Task::find($taskId);
            $this->hidrate();
        } else {
            $this->task = new Task();
        }

        $this->taskPriorities = TaskPriority::where('project_id', $this->project->id)->get();
        $this->taskStatuses = TaskStatus::where('project_id', $this->project->id)->get();
        $this->tags = Tag::where('project_id', $this->project->id)->get();
        $this->users = User::all();
        
        $this->taskTags = TagTask::where('task_id', $this->task->id)->get();
        $this->taskTags = $this->taskTags->pluck('tag_id');
        $this->getFormTitle();
        $this->showTaskRightPopup = true;
        $this->dispatch('setTaskId', $taskId);
        $this->dispatch('$refresh');
    }

    #[On('deleteConfirmed')] 
    public function deleteConfirmed($id)
    {
        $this->dispatch('deleteTask', id: $id);
        // try{
        //     $selectedItem = Task::find($id);
        //     if($selectedItem->delete()){
        //         $this->dispatch('status-message', success: true, message: 'Task has been deleted successfully!');
        //     } else {
        //         $this->dispatch('status-message', success: false, message: 'Task cannot be deleted!');
        //     }
        //     // $this->dispatch('deleteTask', ['id' => $id])->toSelf();
        //     $this->dispatch('deleteTask', taskId: $id)->to(Tasks::class);
        // } catch (Exception $exception) {
        //     $this->dispatch('status-message', success: false, message: $exception->getMessage());
        // }
        // // logger('about to dispatch');
        // // $this->dispatch('deleteTask', $id)->self();
        $this->showTaskRightPopup = false;
    }

    public function closeModal()
    {
        $this->dispatch('removeUnuploadedAttachments');
        
        $this->showTaskRightPopup = false;
    }

    public function store()
    {
        try {
            $user = Auth::user();
            $this->task->user_id = $user->id;
            $this->task->project_id = $user->project_id;

            $this->task->level = $this->taskLevel < 0 ? $this->task->level : $this->taskLevel;
            $this->task->parent = $this->taskParent < 1 ? $this->task->parent : $this->taskParent;
            $this->dehidrate();

            $this->validate();
            $this->task->save();
            $assignmentChanged = $this->task->wasChanged('assigned_to');

            $parentTask = $this->task->getParent()?->first();
            $this->task->path = $parentTask != null ? $parentTask->path.'.'.$this->task->id : $this->task->id;
            
            $this->task->save();

            $this->task->tags()->sync($this->taskTags); 

            if($assignmentChanged){
                $assignee = User::find($this->task->assigned_to);
                if($assignee){
                    Notification::send($assignee, new TaskAssignment($this->task));
                }
            }
            $this->dispatch('saveAttachments', $this->task->id);

            $this->dispatch('status-message', success: true, message: 'Task has been saved successfully!');
        } catch (Exception $exception) {
            $this->dispatch('status-message', success: false, message: $exception->getMessage());
        }
        $this->showTaskRightPopup = false;
    }

    public function mount()
    {
        $this->task = new Task();
        $this->project = Project::find(Auth::user()->project_id);
    }

    public function render()
    {
        $this->datePickerDisabled = $this->task->id > 0 && $this->task->level != 2 ? "disabled" : '';
        return view('livewire.tasks.task-right-popup');
    }

    //-------------------------------Private Functions--------------------------------
    private function hidrate()
    {
        $this->title = $this->task->title;
        $this->start_date = $this->task->start_date ? Carbon::parse($this->task->start_date)->format('d-M-Y') : null;
        $this->end_date = $this->task->end_date ? Carbon::parse($this->task->end_date)->format('d-M-Y') : null;
        $this->assigned_to = $this->task->assigned_to;
        $this->report_by = $this->task->report_by;
        $this->description = $this->task->description;
        $this->task_priority_id = $this->task->task_priority_id;
        $this->task_status_id = $this->task->task_status_id;
        $this->progress = $this->task->progress ? $this->task->progress * 100 : 0;
    }

    private function dehidrate()
    {
        $this->task->title = $this->title;
        $this->task->start_date = Carbon::parse($this->start_date);
        $this->task->end_date = Carbon::parse($this->end_date);
        $this->task->assigned_to = $this->assigned_to ? $this->assigned_to : 0;
        $this->task->report_by = $this->report_by ? $this->report_by : 0;
        $this->task->description = $this->description;
        $this->task->task_priority_id = $this->task_priority_id;
        $this->task->task_status_id = $this->task_status_id;
        $this->task->progress = $this->progress ? $this->progress / 100 : 0;
    }

}
