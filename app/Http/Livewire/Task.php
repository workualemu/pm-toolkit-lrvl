<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Task extends Component
{
    public $count = 0;
    public $title = "";
 
    public function mount($task_title)
    {
        $this->title = $task_title;
    }

    public function render()
    {

        return view('livewire.task', [
            'task' => $this->title,
        ]);
    }
}
