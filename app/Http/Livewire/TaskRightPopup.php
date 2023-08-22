<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use App\Models\Tag;
use App\Models\TagTask;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use App\Models\File;
use Livewire\TemporaryUploadedFile;

class TaskRightPopup extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public Task $task;
    public $taskPriorities = [];
    public $taskStatuses = [];
    public $tags = [];
    public $taskTags = [];
    public $users = [];

    public $files = [];

    public $file = 's9fwyeVg3ZO1j1V2vyNILxYD0PqqAl-metaZXhwb3J0ICg0KS54bHN4-.xlsx';

    public $title;

    protected $rules = [
        'task.title' => 'required|min:2',
        'task.user_id' => 'required',
        'task.planned_end_date'=>'',
        'task.task_priority_id'=>'required',
        'task.task_status_id'=>'required',
        'tagTasks.tag_id'=>'',
        'task.description' => '',
        'task.assigned_to'=>'',
    ];
    protected $listeners = ['openTaskModal' => 'openModal',
                            'addFile' => 'addFile'];

    public function addFile($file)
    {
        
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

    public function openModal($task_id)
    {
        $attachments = File::filterByTask($task_id)->get();

        $this->files = TemporaryUploadedFile::serializeMultipleForLivewireResponse($attachments);
        // $this->files = TemporaryUploadedFile::unserializeFromLivewireRequest($files);

        $this->task = new Task();
        if($task_id > 0) {
            $this->task = Task::find($task_id);
        }

        $this->taskPriorities = TaskPriority::all();
        $this->taskStatuses = TaskStatus::all();
        $this->tags = Tag::all();
        $this->users = User::all();

        $this->taskTags = TagTask::where(['task_id'=>$this->task->id])->get();
        $this->taskTags = $this->taskTags->pluck('tag_id');
        // dd($this->taskTags);

        $this->showModal = true;
        $this->emit('taskModalOpenForCommentModel', $this->task);
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

        $this->task->tags()->detach();    
        $this->task->tags()->attach($this->taskTags);   

        $this->task->refresh();

        $this->showModal = false;
        $this->emit('refreshTasks');

    }

    public function mount()
    {
        $this->modalTask = new Task();
        $this->task = new Task();
    }

    public function render()
    {
        return view('livewire.task-right-popup');
    }

}
