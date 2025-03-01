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
        $this->taskId = $taskId;
        $this->loadSavedFiles($taskId);
    }

    #[On('removeUnuploadedAttachments')]
    public function onRemoveUnuploadedAttachments()
    {
        logger('removeUnuploadedAttachments');
        foreach ($this->savedFiles as $file) {
            if(!isset($file['id']))
            {
                Storage::disk('private')->delete($file['file_path']);
            }
        } 

        $this->files = [];
        $this->deleteOldTempFiles();
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

        foreach ($this->savedFiles as $file) {
            if(!isset($file['id']))
            {
                TaskFile::create([
                    'task_id' => $taskId,
                    'file_path' => $file['file_path'],
                    'file_name' => $file['file_name'],
                ]);
            }
        }
        $this->loadSavedFiles($taskId);
        $this->files = [];
        session()->flash('message', 'Files uploaded successfully.');
    }

    public function loadSavedFiles($taskId)
    {
        $this->savedFiles = TaskFile::where('task_id', $taskId)
            ->get()
            ->map(fn($file) => [
                'id' => $file->id,
                'download_url' => route('files.download', ['id' => $file->id]), 
                'view_url' => route('files.view', ['id' => $file->id]), 
                'file_name' => $file->file_name, 
                'file_size' => Storage::exists('private/' . $file->file_path) 
                    ? Storage::size('private/' . $file->file_path) 
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

    // #[On('saveUploads')]
    // public function onSaveUploads()
    // {
    //     $this->validate([
    //         'files.*' => 'required|file|max:10240', 
    //     ]);

    //     foreach ($this->files as $file) {
    //         $path = $file->store('uploads', 'private');
    //         TaskFile::create([
    //             'task_id' => $this->taskId,
    //             'file_path' => $path,
    //             'file_name' => $file->getClientOriginalName(),
    //         ]);

    //         $this->fileRemoved($file->getFilename());
    //     }

    //     foreach ($this->unsavedFiles as $serverId) {
    //         $this->deleteUploadedFile($serverId);
    //     }

    //     $this->files = [];
    //     $this->loadSavedFiles($this->taskId);
    //     session()->flash('message', 'Files uploaded successfully!');
    // }

    #[On('removeFileConfirmed')]
    public function onRemoveFileConfirmed($id)
    {
        try {
            $file = TaskFile::find($id);
            if (!$file) {
                $this->dispatch('status-message', success: false, message: 'File not found.');
                return;
            }

            if (Storage::disk('private')->exists($file->file_path)) {
                Storage::disk('private')->delete($file->file_path);
            }

            $file->delete();
            $this->dispatch('status-message', success: true, message: 'File removed successfully.');
            $this->dispatch('refreshFiles');
        } catch (Exception $exception) {
            $this->dispatch('status-message', success: false, message: $exception->getMessage());
        }
        $this->dispatch('$refresh');
    }

    public function removeSelectedFile($index)
    {
        $files_index = $index - count($this->savedFiles) + count($this->files);  
        if (isset($files_index) ) {
            array_splice($this->files,  $files_index, 1); 
        }

        if (isset($this->savedFiles[$index])) {
            $tempFile = $this->savedFiles[$index];
            Storage::disk('private')->delete($tempFile['file_path']);
            array_splice($this->savedFiles, $index, 1);
        }
    }

    public function deleteOldTempFiles()
    {
        $tempDir = Storage::disk('public')->path('livewire-tmp');

        foreach (scandir($tempDir) as $file) {
            if ($file != '.' && $file != '..' && time() - filemtime($tempDir . '/' . $file) > 28800) { 
                Storage::delete('livewire-tmp/' . $file);
            }
        }
    }

    public function mount($taskId)
    {
        $this->taskId = $taskId;
        $this->loadSavedFiles($taskId);
    }

    #[On('upload:finished')]
    public function processFiles()
    {
        if (empty($this->files)) {
            return;
        }

        foreach ($this->files as $file) {
            $storedPath = $file->store('task_files', 'private');
            $this->savedFiles[] = [
                'file_path' => $storedPath,
                'file_name' => $file->getClientOriginalName(),
            ];
        }

    }

    // public function deleteFile($filePath)
    // {
    //     Storage::delete($filePath);
    //     $this->files = array_filter($this->files, fn($file) => $file !== $filePath);
    // }

    public function render()
    {
        return view('livewire.tasks.task-file-upload', [
            'storedFiles' => $this->savedFiles
        ]);
    }
}
