<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Report;

class ReportsAdmin extends Component
{
    public $reports = [];
    public $selectedReportId;
    public $showReportModal = false;

    protected $listeners = ['refreshReport' => '$refresh'
    ];

    public function addNewReport()
    {
        $this->emit('openReportModal', null);
    }

    public function editReport($report_id)
    {
        $this->emit('openReportModal', $report_id);
    }

    public function updateParamColumn($report_id)
    {
        $this->selectedReportId = $report_id;
        $this->emit('renderReportParam', $report_id);
        $this->emit('renderReportColumn', $report_id);
    }


    public function render()
    {
        $this->reports = Report::all();
        return view('livewire.reports-admin');
    }
}
