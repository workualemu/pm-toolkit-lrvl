<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class KanbanList extends Component
{
    public $tasks;
    public $kanbanList;

    public function mount()
    {
        $user =  Auth::user();

        $searchValue = [['project_id', $user->project_id]];
        $this->tasks = Task::where($searchValue )->get();
    }

    public function render()
    {
        return view('livewire.kanban-list');
    }
}
