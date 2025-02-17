<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Report;
use Livewire\Attributes\On;

class ReportsAdmin extends Component
{
    // public $reports = [];
    public $selectedReportId;
    public $showReportModal = false;

    #[On('refreshReport')]
    public function refreshReport()
    {
        $this->dispatch('$refresh');
    }

    public function addNewReport()
    {
        $this->dispatch('openReportModal', null);
    }

    public function editReport($report_id)
    {
        $this->dispatch('openReportModal', $report_id);
    }

    public function updateParamColumn($report_id)
    {
        $this->selectedReportId = $report_id;
        $this->dispatch('renderReportParam', $report_id);
        $this->dispatch('renderReportColumn', $report_id);
    }

    #[On('deleteConfirmed')] 
    public function deleteConfirmed($id)
    {
        Report::findOrFail($id)->delete();
        session()->flash('message', 'Report deleted successfully.');
    }

    public function render()
    {
        $user = \Auth::user();
        return view('livewire.settings.reports-admin', [
            'reports' => Report::where('project_id', $user->project_id)->paginate(10),
        ]);
    }
}
