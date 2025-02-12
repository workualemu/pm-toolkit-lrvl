<?php

namespace App\Http\Livewire;

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
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use App\Notifications\TaskAssignment;
use Carbon\Carbon;
use Livewire\Attributes\On;

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

    public $files = [];

    public $file = 's9fwyeVg3ZO1j1V2vyNILxYD0PqqAl-metaZXhwb3J0ICg0KS54bHN4-.xlsx';

    #[Validate('required|min:5')]
    public $title = '';

    public $start_date = '';
    public $end_date = '';
    public $assigned_to = -1;
    public $report_by = -1;
    public $description = '';
    public $task_priority_id = -1;
    public $task_status_id = -1;

    protected $rules = [
        'task.title' => 'required|min:2',
        'task.user_id' => 'required',
        'task.start_date'=>'',
        'task.end_date'=>'',
        'task.task_priority_id'=>'required',
        'task.task_status_id'=>'required',
        'tagTasks.tag_id'=>'',
        'task.description' => '',
        'task.assigned_to'=>'',
        'task.report_by'=>'',
    ];
    // protected $listeners = ['openTaskModal' => 'openModal',
    //                         'fileDownloaded' => 'downloadFile',
    //                     ];

    #[On('downloadFile')]
    public function downloadFile($file)
    {
        logger('downloadFile is captured');
    }

    public function finishUpload($name, $tmpPath, $isMultiple)
    {
        $this->cleanupOldUploads();

        $files = collect($tmpPath)->map(function ($i) {
            return TemporaryUploadedFile::createFromLivewire($i);
        })->toArray();

        $this->emitSelf('upload:finished', $name, collect($files)->map->getFilename()->toArray());

        $this->syncInput($name, $files);

        foreach($files as $file){
            File::updateOrCreate(
                ['path' => $file->getPath(), 'task_id' => $this->task->id],
                ['name' => $file->getFileName()]
            );
        }

    }

    // public function downloadFile($file, $originalFileName)
    // {
    //     return response()->download(storage_path('app/livewire-tmp/'.$file), $originalFileName);
    // }

    public function removeUpload($name, $tmpFilename)
    {
        $uploads = $this->getPropertyValue($name);

        if (is_array($uploads) && isset($uploads[0]) && $uploads[0] instanceof TemporaryUploadedFile) {
            $this->emit('upload:removed', $name, $tmpFilename)->self();

            $this->syncInput($name, array_values(array_filter($uploads, function ($upload) use ($tmpFilename) {
                if ($upload->getFilename() === $tmpFilename) {
                    $numb = File::where(['task_id'=>$this->task->id, 'name'=> $upload->getFilename()])->delete();
                    $upload->delete();
                    return false;
                }
                return true;
            })));
        } elseif ($uploads instanceof TemporaryUploadedFile && $uploads->getFilename() === $tmpFilename) {
            $uploads->delete();

            $this->emit('upload:removed', $name, $tmpFilename)->self();

            $this->syncInput($name, null);
        }
    }

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

        // $this->files = TemporaryUploadedFile::serializeMultipleForLivewireResponse($attachments);
        
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
    }

    public function closeModal()
    {
        $this->showTaskRightPopup = false;
        // $this->emit('clearFilePond');
    }

    public function store()
    {
        $user = Auth::user();
        $this->task->user_id = $user->id;
        $this->task->project_id = $user->project_id;

        $this->task->level = $this->taskLevel < 0 ? $this->task->level : $this->taskLevel;
        $this->task->parent = $this->taskParent < 1 ? $this->task->parent : $this->taskParent;
        $this->dehidrate();

        $this->task->save();

        $parentTask = $this->task->getParent()?->first();
        $this->task->path = $parentTask != null ? $parentTask->path.'.'.$this->task->id : $this->task->id;
        
        $this->task->save();

        $this->task->tags()->detach();    
        $this->task->tags()->attach($this->taskTags);   

        // $this->task->refresh();

        if($this->task->isDirty('assigned_to') ){
            $assgnee = User::find($this->task->assigned_to);
            Notification::send($assgnee, new TaskAssignment($this->task));
        }

        // $this->emit('saveUploads', $this->task->id);

        $this->dispatch('refreshSingleTask', $this->task->id);
        // $this->emitTo('task-component', 'refreshSingleTask', $this->task->id);
        $this->showTaskRightPopup = false;
    }

    public function mount($taskId = null)
    {
        $this->task = $taskId ? Task::find($taskId) : new Task();

        $this->modalTask = new Task();
        // $this->task = new Task();
        $this->project = Project::find(Auth::user()->project_id);
        $this->getFormTitle();
    }

    public function render()
    {
        return view('livewire.task-right-popup');
    }


    //-------------------------------Private Functions--------------------------------
    private function hidrate()
    {
        $this->title = $this->task->title;
        $this->start_date = $this->task->start_date ? Carbon::parse($this->task->start_date)->format('M-d-Y') : null;
        $this->end_date = $this->task->end_date ? Carbon::parse($this->task->end_date)->format('M-d-Y') : null;
        $this->assigned_to = $this->task->assigned_to;
        $this->report_by = $this->task->report_by;
        $this->description = $this->task->description;
        $this->task_priority_id = $this->task->task_priority_id;
        $this->task_status_id = $this->task->task_status_id;
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
    }

}
