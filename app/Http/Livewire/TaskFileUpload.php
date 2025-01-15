<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\TaskFile;
use Illuminate\Support\Facades\Storage;

class TaskFileUpload extends Component
{
    use WithFileUploads;

    public $files = []; 
    public $savedFiles = []; 
    public $taskId; 
    public $uploadedFiles = []; 

    protected $listeners = ['setTaskId', 'refreshFiles',
                            'saveUploads' => 'onSaveUploads'];

    public function setTaskId($taskId)
    {
        $this->taskId = $taskId;
        // $this->loadSavedFiles($taskId);
    }

    public function loadSavedFiles($taskId)
    {
        // $this->savedFiles = TaskFile::where('task_id', $taskId)->get();
        $this->savedFiles = TaskFile::where('task_id', $taskId)->get()->map(function ($file) {
            return [
                'id' => $file->id,
                'file_path' => Storage::url($file->file_path),
                'file_name' => basename($file->file_path),
                'file_size' => Storage::size($file->file_path),
            ];
        })->toArray();
    }

    public function refreshFiles()
    {
        // $this->loadSavedFiles(); 
    }

    public function loadUploadedFiles()
    {
        $this->$files = TaskFile::where('task_id', $this->taskId)->get();
    }

    public function onSaveUploads($taskId)
    {
        $this->validate([
            'files.*' => 'required|file|max:10240', // Validate each file
        ]);

        foreach ($this->files as $file) {
            $path = $file->store('task-files', 'public'); 

            // Save file information to the database
            TaskFile::create([
                'task_id' => $taskId, // Example Task ID
                'file_path' => $path,
            ]);
        }

        // Reset the files property
        $this->reset('files');

        // Emit event to reset FilePond
        $this->emit('resetFilePond');

        session()->flash('message', 'Files uploaded successfully!');
    }

    public function mount($taskId)
    {
        $this->taskId = $taskId;
    }

    public function render()
    {
        return view('livewire.task-file-upload', [
            'savedFiles' => $this->savedFiles,
        ]);
    }
}
