<?php

namespace App\Http\Livewire\Partials\Tasks;

use Livewire\Component;
use App\Models\TaskStatus;
use App\Models\Task;
use Livewire\Attributes\On;

class Header extends Component
{
    public $phases =[];
    public $statuses =[];
    public $filterClause = [];
    public $title;
    public $showStatusFilter;

    public $searchTerm;
    public $fTitle = '';
    public $fPhase;
    public $fDateFrom;
    public $fDateTo;
    public $selectedStatuses = [];
    public $sidebarFilter = [];

    public $filterStatuses = [];

    #[On('resetHeaderCriteria')]
    public function onResetHeaderCriteria()
    {
        $this->searchTerm = null;
        $this->fTitle = null;
        $this->fPhase =null;
        $this->fDateFrom = null;
        $this->fDateTo = null;
        $this->selectedStatuses = [];
        $this->dispatch('$refresh');
    }

    public function resetFilterCriteria()
    {
        $this->fTitle = null;
        $this->fPhase =null;
        $this->fDateFrom = null;
        $this->fDateTo = null;
        $this->selectedStatuses = [];
        $this->dispatch('$refresh');
    }

    public function updatedSearchTerm()
    {
        $this->resetFilterCriteria();
        
        $filterParams = [
            'fTitle' => null,
            'fPhase' => null,
            'fDateFrom' => null,
            'fDateTo' => null,
            'fStatus' => [],
            'searchTerm' => $this->searchTerm ?? null,
            'sidebarFilter' => null,
            'fPriority' => null,
            'fTaskIds' => null,
            'fAssignee' => null,
        ];

        $this->dispatch('filterTasksWithHeader', $filterParams);
    }

    /**
     * Filters tasks based on the provided filtering variables.
     *
     * Filtering variables:
     * - $this->filterClause: Additional filter clauses.
     * - $this->searchTerm: Term to search in task titles and descriptions.
     * - $this->fTitle: Filter by title.
     * - $this->fPhase: Filter by phase.
     * - $this->fDateFrom: Filter tasks from this date.
     * - $this->fDateTo: Filter tasks up to this date.
     * - $this->selectedStatuses: Array of selected status IDs to filter tasks.
     *
     * @return tasks
     */
    public function applyFilter()
    {
        $this->serachTerm = '';
        $this->dispatch('$refresh');
        $filterParams = [
            'fTitle' => $this->fTitle,
            'fPhase' => $this->fPhase,
            'fDateFrom' => $this->fDateFrom,
            'fDateTo' => $this->fDateTo,
            'fStatus' => $this->selectedStatuses,
            'searchTerm' => null,
            'sidebarFilter' => $this->sidebarFilter,
            'fPriority' => null,
            'fTaskIds' => null,
            'fAssignee' => null,
        ];
        
        $this->dispatch('filterTasksWithHeader', $filterParams);
    }

    public function render()
    {
        $user = \Auth::user();
        $this->statuses = TaskStatus::where('project_id', $user->project_id)->get();
        $this->phases = Task::whereNull('parent')
            ->where('project_id', $user->project_id)
            ->get();
        
        return view('livewire.partials.tasks.header');
    }
}
