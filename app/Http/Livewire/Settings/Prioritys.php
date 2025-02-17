<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\TaskPriority;
use Livewire\Attributes\On;

class Prioritys extends Component
{
    public $prioritys = [];
    public $showPriorityModal = false;

    #[On('refreshPriority')]
    public function refreshPriority()
    {
        $this->dispatch('$refresh');
    }

    public function addNewPriority()
    {
        $this->dispatch('openPriorityModal', null);
    }

    public function editPriority($priority_id)
    {
        $this->dispatch('openPriorityModal', $priority_id);
    }

    #[On('deleteConfirmed')] 
    public function deleteConfirmed($id)
    {
        logger('deleteConfirmed');
        TaskPriority::findOrFail($id)->delete();
        session()->flash('message', 'Priority deleted successfully.');
    }

    public function deletePriority($priority_id)
    {
        $res=TaskPriority::where('id', $priority_id)->delete();
        $this->dispatch('$refresh');
    }

    public function render()
    {
        $user = \Auth::user();

        $this->prioritys = TaskPriority::where('project_id', $user->project_id)->get();
        return view('livewire.settings.prioritys');
    }
}
