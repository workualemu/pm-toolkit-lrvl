<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\TaskStatus;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class TaskStatuses extends Component
{
    use WithPagination;

    public $searchTerm;

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    #[On('refreshStatus')]
    public function refreshStatus()
    {
        $this->dispatch('$refresh');
    }

    public function addNewStatus()
    {
        $this->dispatch('openStatusModal', null);
    }

    public function editStatus($status_id)
    {
        $this->dispatch('openStatusModal', $status_id);
    }

    #[On('deleteConfirmed')] 
    public function deleteConfirmed($id)
    {
        try{
            $selectedItem = TaskStatus::find($id);
            if($selectedItem->delete()){
                $this->dispatch('status-message', success: true, message: 'Status has been deleted successfully!');
            } else {
                $this->dispatch('status-message', success: false, message: 'Status cannot be deleted!');
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

        $records = TaskStatus::where('project_id', auth()->user()->project_id) 
            ->when($this->searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereRaw('LOWER(value) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(description) LIKE ?', [$searchTerm]);
                });
            })
            ->orderBy('kanban_list_rank')
            ->paginate(10);

        if ($records->isEmpty() && $this->getPage() > 1) {
            $this->resetPage(); 
        }

        return view('livewire.settings.task-statuses', [
            'statuses' => $records,
        ]);

    }
}
