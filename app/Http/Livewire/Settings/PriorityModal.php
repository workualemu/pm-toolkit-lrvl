<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\TaskPriority;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule as LivewireRule;

class PriorityModal extends Component
{
    public $priority;
    public $showModal = false;
    
    public $currentColor;

    #[LivewireRule('required|string|min:2')] 
    public $value;

    public $user_id;
    public $description;
    public $color;

    #[On('openPriorityModal')]
    public function openPriorityModal($priority_id)
    {
        $this->priority = new TaskPriority();
        if($priority_id > 0) {
            $this->priority = TaskPriority::find($priority_id);
        }
        $this->hidrate();
        
        // $this->currentColor =  $this->priority->color ?? 'blue';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function store()
    {
        $this->dehidrate();
        $user = Auth::user();
        $this->priority->user_id = $user->id;
        $this->priority->project_id = $user->project_id;
        // $this->priority->color = $this->currentColor;

        $this->priority->save();
        // $this->priority->refresh();

        $this->dispatch('refreshPriority');
        $this->showModal = false;
    }

    public function mount()
    {
        $this->priority = new TaskPriority();
    }

    public function render()
    {
        return view('livewire.settings.priority-modal');
    }
    //------------------------------------------Private Methods ------------------------------------
    private function hidrate()
    {
        $this->value = $this->priority->value;
        $this->description = $this->priority->description;
        $this->color = $this->priority->color;
    }

    private function dehidrate()
    {
        $this->priority->value = $this->value;
        $this->priority->description = $this->description;
        $this->priority->color = $this->color;
    }
    
}
