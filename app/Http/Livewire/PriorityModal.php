<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TaskPriority;
use Illuminate\Support\Facades\Auth;

class PriorityModal extends Component
{
    public $priority;
    public $showModal = false;
    
    public $currentColor;

    protected $rules = [
        'priority.value' => 'required|min:2',
        'priority.user_id' => 'required',
        'priority.description'=>'',
        'priority.color' => ''
    ];

    protected $listeners = ['openPriorityModal' => 'openPriorityModal'];

    public function openPriorityModal($priority_id)
    {
        $this->priority = new TaskPriority();
        if($priority_id > 0) {
            $this->priority = TaskPriority::find($priority_id);
        }
        
        $this->currentColor =  $this->priority->color ?? 'blue';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function store()
    {
        $user = Auth::user();
        $this->priority->user_id = $user->id;
        $this->priority->color = $this->currentColor;

        $this->priority->save();
        $this->priority->refresh();

        $this->emit('refreshPriority');
        $this->showModal = false;

    }

    public function mount()
    {
        $this->priority = new TaskPriority();
    }

    public function render()
    {
        return view('livewire.priority-modal');
    }
}
