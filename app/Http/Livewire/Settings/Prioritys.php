<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\TaskPriority;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Prioritys extends Component
{
    use WithPagination;

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
        try{
            $selectedItem = TaskPriority::find($id);
            if($selectedItem->delete()){
                $this->dispatch('status-message', success: true, message: 'Priority has been deleted successfully!');
            } else {
                $this->dispatch('status-message', success: false, message: 'Priority cannot be deleted!');
            }
            $selectedItem->refresh();
        } catch (Exception $exception) {
            $this->dispatch('status-message', success: false, message: $exception->getMessage());
        }
        $this->dispatch('$refresh');
    }

    public function render()
    {
        $searchTerm = '%' . strtolower($this->searchTerm) . '%';

        $priorities = TaskPriority::where('project_id', auth()->user()->project_id) 
            ->when($this->searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereRaw('LOWER(value) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(description) LIKE ?', [$searchTerm]);
                });
            })
            ->paginate(10);

        if ($priorities->isEmpty() && $this->page > 1) {
            $this->resetPage(); 
        }

        return view('livewire.settings.prioritys', [
            'records' => $priorities,
        ]);
    }
}
