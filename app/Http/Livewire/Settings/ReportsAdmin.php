<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Report;
use Livewire\Attributes\On;

class ReportsAdmin extends Component
{
    public $searchTerm;

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

    #[On('deleteConfirmed')] 
    public function deleteConfirmed($id)
    {
        Report::findOrFail($id)->delete();
        $this->dispatch('$refresh');
    }

    public function render()
    {
        $searchTerm = '%' . strtolower($this->searchTerm) . '%';

        $records = Report::where('project_id', auth()->user()->project_id) 
            ->when($this->searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereRaw('LOWER(title) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(description) LIKE ?', [$searchTerm]);
                });
            })
            ->paginate(10);

        return view('livewire.settings.reports-admin', [
            'reports' => $records,
        ]);
    }
}
