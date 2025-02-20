<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule as LivewireRule;

class TaskStatusModal extends Component
{
    public $todo ='';
    public $status;
    public $selectedColor;
    public $showModal = false;

    public $currentColor;

    #[LivewireRule('required|string|min:2')] 
    public $value;
    public $user_id;
    public $description;
    public $kanban_list_rank;
    public $color;

    #[On('openStatusModal')]
    public function openStatusModal($status_id)
    {
        $this->status = new TaskStatus();
        if($status_id > 0) {
            $this->status = TaskStatus::find($status_id);
        }
        $this->hidrate();
        // $this->currentColor =  $this->status->color ?? 'blue';
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
        $this->status->project_id = $user->project_id;
        // $this->status->color =  $this->currentColor;
        $this->dehidrate();
        
        $this->status->save();
        // $this->status->refresh();
        $this->dispatch('refreshStatus');
        $this->showModal = false;

    }

    public function mount()
    {
        $this->status = new TaskStatus();
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.settings.task-status-modal');
    }

    //------------------------------------------Private Methods ------------------------------------
    private function hidrate()
    {
        $this->value = $this->status->value;
        $this->description = $this->status->description;
        $this->kanban_list_rank = $this->status->kanban_list_rank;
        $this->color = $this->status->color;
    }

    private function dehidrate()
    {
        $this->status->value = $this->value;
        $this->status->description = $this->description;
        $this->status->kanban_list_rank = $this->kanban_list_rank;
        $this->status->color = $this->color;
    }
}
