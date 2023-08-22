<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;

class TaskStatusModal extends Component
{
    public $status;
    public $showModal = false;

    protected $rules = [
        'status.value' => 'required|min:2',
        'status.user_id' => 'required',
        'status.description'=>'',
        'status.kanban_list_rank'=>''
    ];

    protected $listeners = ['openStatusModal' => 'openStatusModal'];

    public function openStatusModal($status_id)
    {
        $this->status = new TaskStatus();
        if($status_id > 0) {
            $this->status = TaskStatus::find($status_id);
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function store()
    {
        $user = Auth::user();
        $this->status->user_id = $user->id;
        // $this->status->color = $this->colorSelected;

        $this->status->save();
        $this->status->refresh();

        $this->emit('refreshStatus');
        $this->showModal = false;

    }

    public function mount()
    {
        $this->status = new TaskStatus();
    }

    public function render()
    {
        return view('livewire.task-status-modal');
    }
}
