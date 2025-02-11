<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\TaskFile;
use Illuminate\Support\Facades\Storage;
// use Livewire\WithEvents;

class TaskFileUpload extends Component
{
    use WithFileUploads;

    public $files = []; 
    public $savedFiles = []; 
    public $unsavedFiles = [];
    public $taskId; 
    public $uploadedFiles = []; 

    // protected $listeners = [
    //     'setTaskId', 
    //     'refreshFiles',
    //     'saveUploads' => 'onSaveUploads', 
    //     'fileRemoved',
    //     'fileDeleted' => 'deleteUploadedFile',
    //     'trackUnsavedFiles' => 'trackUnsavedFiles',
    //     'resetTrackingUnsavedFiles' => 'resetTrackingUnsavedFiles',
    // ];

    #[On('setTaskId')]
    public function setTaskId($taskId)
    {
        $this->taskId = $taskId;
        $this->loadSavedFiles($taskId);
    }

    public function loadSavedFiles($taskId)
    {
        // $this->savedFiles = TaskFile::where('task_id', $taskId)->get();
        $this->savedFiles = TaskFile::where('task_id', $taskId)->get()->map(function ($file) {
            return [
                'id' => $file->id,
                'file_path' => Storage::url($file->file_path),
                'file_name' => $file->file_name,
                'file_size' => Storage::exists('public/' . $file->file_path) ? Storage::size('public/' . $file->file_path) : 0,
            ];
        })->toArray();

        $this->dispatch('savedFilesUpdated', $this->savedFiles);
    }

    #[On('refreshFiles')]
    public function refreshFiles()
    {
        $this->reset('files');
        $this->loadSavedFiles(); 
    }

    public function loadUploadedFiles()
    {
        $this->$files = TaskFile::where('task_id', $this->taskId)->get();
    }

    #[On('saveUploads')]
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
                'file_name' => basename($file->getClientOriginalName()),
            ]);

            $this->fileRemoved($file->getFilename());
        }

        // Clear the unsaved files array which deletes the saved files from database and storage
        foreach($this->unsavedFiles as $serverId) {
            $this->deleteUploadedFile($serverId);
        }

        $this->files = [];

        $this->loadSavedFiles($taskId);

        session()->flash('message', 'Files uploaded successfully!');
    }

    #[On('fileRemoved')]
    public function fileRemoved($serverId)
    {
        // Temporary storage directory path (relative to the storage directory)
        $tempDirectory = storage_path('app/task-files');  // Absolute path to 'storage/app/task-files'

        // Loop through the files array and remove the file with the corresponding serverId
        $this->files = array_filter($this->files, function ($file) use ($serverId, $tempDirectory) {
            // Check if the filename matches the serverId (you can adjust this condition based on your file naming)
            if ($file->getFilename() === $serverId) {
                // Construct the full file path for temporary storage
                $tempFilePath = $tempDirectory . DIRECTORY_SEPARATOR . $file->getFilename();
        
                // Check if the file exists before attempting to delete it
                if (file_exists($tempFilePath)) {
                    // Delete the file from the temporary storage
                    unlink($tempFilePath);  // This deletes the file
        
                    // Optionally log or handle any errors if needed
                    if (!file_exists($tempFilePath)) {
                        // Success: file was deleted
                    } else {
                        // Handle failure, e.g., log the error
                        error_log("Failed to delete file from temp storage: " . $tempFilePath);
                    }
                }
            }
        
            // Return false to exclude the file from the array
            return $file->getFilename() !== $serverId;
        });
    }

    #[On('fileDeleted')]
    public function deleteUploadedFile($fileId)
    {
        // Find the file record by its ID
        $file = TaskFile::find($fileId); // Use $fileId directly here

        if ($file) {
            $filePath = 'public/' . $file->file_path;

            // Check if the file exists in storage
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            $file->delete(); // Delete the file record

            $this->removeUnsavedFiles($fileId); 
            $this->dispatch('fileDeleted', $fileId); 
        } else {
            session()->flash('error', 'File not found!');
        }
    }

    #[On('trackUnsavedFiles')]
    public function trackUnsavedFiles($serverId)
    {
        // add if the serverId is not in the array
        if(!in_array($serverId, $this->unsavedFiles))
        {
            $this->unsavedFiles[] = $serverId;
            $this->dispatch('unsavedFilesUpdated', $this->unsavedFiles);
        }

    }

    public function removeUnsavedFiles($serverId) 
    {
        $this->unsavedFiles = array_filter($this->unsavedFiles, function ($id) use ($serverId) {
            return $id !== $serverId;
        });
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

    public function render()
    {
        return view('livewire.task-file-upload', [
            'savedFiles' => $this->savedFiles,
        ]);
    }
}
