<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\TaskPriority;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Prioritys extends Component
{
    use WithPagination;

    public $prioritys = [];
    public $showPriorityModal = false;
    public $searchTerm;

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
        TaskPriority::findOrFail($id)->delete();
        $this->dispatch('$refresh');
    }

    public function render()
    {
        $searchTerm = '%' . strtolower($this->searchTerm) . '%';

        $records = TaskPriority::where('project_id', auth()->user()->project_id) 
            ->when($this->searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereRaw('LOWER(value) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(description) LIKE ?', [$searchTerm]);
                });
            })
            ->paginate(10);

        return view('livewire.settings.prioritys', [
            'records' => $records,
        ]);
    }
}
