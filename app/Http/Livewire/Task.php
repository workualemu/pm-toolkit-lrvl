<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Task extends Component
{
    public $showModal = false;
    public $modalTask = [];

    public function openModal($data)
    {
        $this->emit('openTaskModal', $data);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function storeTask($task)
    {
        // Perform data saving or processing logic here
        // You can access the form data using $this->name and $this->email

        // After saving or processing the data, you can reset the form fields

        dd('here');
        $this->reset(['title']);

        // Close the modal after saving data
        $this->showModal = false;
        
    }

    public function mount($task)
    {
        $this->task = $task;
    }

    public function render()
    {
        return view('livewire.task', [
            'task' => $this->task,
        ]);
    }
}
