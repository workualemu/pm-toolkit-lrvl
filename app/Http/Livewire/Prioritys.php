<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TaskPriority;

class Prioritys extends Component
{
    public $prioritys = [];
    public $showPriorityModal = false;

    protected $listeners = ['refreshPriority' => '$refresh'
    ];

    public function addNewPriority()
    {
        $this->emit('openPriorityModal', null);
    }

    public function editPriority($priority_id)
    {
        $this->emit('openPriorityModal', $priority_id);
    }

    public function deletePriority($priority_id)
    {
        $res=TaskPriority::where('id', $priority_id)->delete();
        // $this->emit('openPriorityModal', $priority_id);
    }

    public function render()
    {
        $this->prioritys = TaskPriority::all();
        return view('livewire.prioritys');
    }
}
