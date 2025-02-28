<?php

namespace App\Http\Livewire\Tasks;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\TaskFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

class TaskFileUpload extends Component
{
    use WithFileUploads;

    #[Validate(['files.*' => 'image|max:2048'])]
    public $files = [];

    public $savedFiles = [];
    public $unsavedFiles = [];
    public $taskId;
    public $uploadedFiles = [];

    #[On('setTaskId')]
    public function setTaskId($taskId)
    {
        logger('setTaskId listened');
        $this->taskId = $taskId;
        $this->loadSavedFiles($taskId);
    }

    #[On('removeUnprocessedAttachments')]
    public function onRemoveUnprocessedAttachments()
    {
        $this->files = [];
    }

    #[On('saveAttachments')]
    public function onSaveAttachments($taskId)
    {
        if (!$taskId) {
            session()->flash('error', 'Task ID is missing.');
            return;
        }

        if (empty($this->files)) {
            return;
        }

        foreach ($this->files as $file) {
            $path = $file->store('task-files', 'public');
            TaskFile::create([
                'task_id' => $taskId,
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
            ]);
        }

        $this->files = [];
        session()->flash('message', 'Files uploaded successfully.');
    }

    public function loadSavedFiles($taskId)
    {
        $this->savedFiles = TaskFile::where('task_id', $taskId)
            ->get()
            ->map(fn($file) => [
                'id' => $file->id,
                'file_path' => Storage::url($file->file_path),
                'file_name' => $file->file_name, 
                'file_size' => Storage::exists('public/' . $file->file_path) 
                    ? Storage::size('public/' . $file->file_path) 
                    : 0,
            ])
            ->toArray();

        $this->dispatch('savedFilesUpdated', $this->savedFiles);
    }


    #[On('refreshFiles')]
    public function refreshFiles()
    {
        $this->reset('files');
        $this->loadSavedFiles($this->taskId);
    }

    public function loadUploadedFiles()
    {
        $this->uploadedFiles = TaskFile::where('task_id', $this->taskId)->get();
    }

    #[On('saveUploads')]
    public function onSaveUploads()
    {
        $this->validate([
            'files.*' => 'required|file|max:10240', 
        ]);

        foreach ($this->files as $file) {
            $path = $file->store('task-files', 'public');
            TaskFile::create([
                'task_id' => $this->taskId,
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
            ]);

            $this->fileRemoved($file->getFilename());
        }

        foreach ($this->unsavedFiles as $serverId) {
            $this->deleteUploadedFile($serverId);
        }

        $this->files = [];
        $this->loadSavedFiles($this->taskId);
        session()->flash('message', 'Files uploaded successfully!');
    }

    #[On('removeFileConfirmed')]
    public function onRemoveFileConfirmed($id)
    {
        try {
            $file = TaskFile::find($id);
            if (!$file) {
                $this->dispatch('status-message', success: false, message: 'File not found.');
                return;
            }
            if (Storage::exists('public/' . $file->file_path)) {
                Storage::delete('public/' . $file->file_path);
            }
            $file->delete();
            $this->dispatch('status-message', success: true, message: 'File removed successfully.');
            $this->dispatch('refreshFiles');
        } catch (Exception $exception) {
            $this->dispatch('status-message', success: false, message: $exception->getMessage());
        }
    }


    #[On('fileRemoved')]
    public function fileRemoved($serverId)
    {
        $this->files = array_filter($this->files, function ($file) use ($serverId) {
            return $file->getFilename() !== $serverId;
        });
    }

    #[On('fileDeleted')]
    public function deleteUploadedFile($fileId)
    {
        $file = TaskFile::find($fileId);

        if ($file) {
            $filePath = 'public/' . $file->file_path;

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            $file->delete();
            $this->removeUnsavedFiles($fileId);
            $this->dispatch('fileDeleted', $fileId);
        } else {
            session()->flash('error', 'File not found!');
        }
    }

    #[On('trackUnsavedFiles')]
    public function trackUnsavedFiles($serverId)
    {
        if (!in_array($serverId, $this->unsavedFiles)) {
            $this->unsavedFiles[] = $serverId;
            $this->dispatch('unsavedFilesUpdated', $this->unsavedFiles);
        }
    }

    public function removeUnsavedFiles($serverId)
    {
        $this->unsavedFiles = array_filter($this->unsavedFiles, fn($id) => $id !== $serverId);
    }

    #[On('resetTrackingUnsavedFiles')]
    public function resetTrackingUnsavedFiles()
    {
        $this->unsavedFiles = [];
    }

    public function mount($taskId)
    {
        $this->taskId = $taskId;
        $this->loadSavedFiles($taskId);
    }

    public function testLivewire()
    {
        logger('Livewire button clicked!');
        session()->flash('message', 'Livewire is working!');
    }

    #[On('upload:finished')]
    public function processFiles()
    {
        logger('in process files');
        if (empty($this->files)) {
            logger('No files available for processing.');
            return;
        }

        foreach ($this->files as $file) {
            $storedPath = $file->store('uploads', 'public');
            $this->savedFiles[] = [
                'file_path' => Storage::url($storedPath),
                'file_name' => $file->getClientOriginalName(),
            ];
        }

        session()->flash('message', 'Files processed successfully.');
    }

    public function removeFile($index)
    {
        unset($this->files[$index]);
        $this->files = array_values($this->files); // Reindex the array
    }

    public function deleteFile($filePath)
    {
        Storage::delete($filePath);
        $this->files = array_filter($this->files, fn($file) => $file !== $filePath);
    }

    public function render()
    {
        return view('livewire.tasks.task-file-upload', [
            'storedFiles' => $this->savedFiles
        ]);
    }
}
