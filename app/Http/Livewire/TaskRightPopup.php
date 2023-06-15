<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TaskRightPopup extends Component
{
    public $showModal = false;
    public $modalTask = [];

    protected $listeners = ['openTaskModal' => 'openModal'];

    public function openModal($data)
    {
        $this->modalTask = $data;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function store()
    {

        dd($this->modalTask);
        $this->reset(['title']);

        // Close the modal after saving data
        $this->showModal = false;
        
    }

    public function mount()
    {
        // $this->modalTask = $task;
    }

    public function render()
    {
        return view('livewire.task-right-popup');
    }
    
}
