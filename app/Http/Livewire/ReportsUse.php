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
    public $showReportUse = true;
    public $results;
    public $queryBuilder;

    public $selectedReportID;
    public $selectedParams;

    public $selectedReportId;

    public $showReportModal = false;

    protected $listeners = ['showReportViewer' => 'showReportViewer',
                            'refreshReportUsePage' => '$refresh'];

    public function showReportViewer($report_id, $results, $queryBuilder)
    {
        $this->selectedReportID = $report_id;
        $this->results = $results;
        $this->showReportUse = false;
        $this->queryBuilder = $queryBuilder;
        $this->emit('refreshReportUsePage');

    }

    public function mount($project)
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
