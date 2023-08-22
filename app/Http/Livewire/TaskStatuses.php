<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TaskStatus;
use Livewire\WithPagination;

class TaskStatuses extends Component
{
    use WithPagination;

    // public $statuses = [];
    public $showStatusModal = false;

    protected $listeners = ['refreshStatus' => '$refresh'
    ];

    public function addNewStatus()
    {
        $this->emit('openStatusModal', null);
    }

    public function editStatus($status_id)
    {
        $this->emit('openStatusModal', $status_id);
    }

    public function deleteStatus($status_id)
    {
        $res=TaskStatus::where('id', $status_id)->delete();
        // $this->emit('openStatusModal', $status_id);
    }

    public function render()
    {
        return view('livewire.task-statuses', [
            'statuses' => TaskStatus::paginate(10),
        ]);

    }
}
