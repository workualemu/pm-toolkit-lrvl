<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\TaskStatus;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class TaskStatuses extends Component
{
    use WithPagination;

    public $showStatusModal = false;

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

    public function deleteStatus($status_id)
    {
        $res=TaskStatus::where('id', $status_id)->delete();
        $this->dispatch('$refresh');
    }

    public function render()
    {
        $user = \Auth::user();

        return view('livewire.settings.task-statuses', [
            'statuses' => TaskStatus::where('project_id', $user->project_id)->orderby('kanban_list_rank')->paginate(10),
        ]);

    }
}
