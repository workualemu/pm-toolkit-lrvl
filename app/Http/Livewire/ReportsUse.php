<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Report;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ReportsUse extends Component
{
    public $reports = [];
    public $project;

    public $selectedReportId;

    public $showReportModal = false;

    public function mount($project_id)
    {
        $user =  Auth::user();
        $this->project = Project::find($user->project_id);
    }

    public function renderUseParam($report_id)
    {
        $this->selectedReportId = $report_id;
        $this->emit('renderUseParam', $report_id);
    }

    public function render()
    {
        $this->reports = Report::where('published', '=', 1)->get();
        return view('livewire.reports-use');
    }
}
