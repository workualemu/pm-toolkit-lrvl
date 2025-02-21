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
        try{
            $selectedReport = Report::findOrFail($id);
            if($selectedReport->delete()){
                $this->dispatch('status-message', success: true, message: 'Report has been deleted successfully!');
            } else {
                $this->dispatch('status-message', success: false, message: 'Report cannot be deleted!');
            }
            $selectedReport->refresh();
            
        } catch (Exception $exception) {
            $this->dispatch('status-message', success: false, message: $exception->getMessage());
        }
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

        if ($records->isEmpty() && $this->page > 1) {
            $this->resetPage(); 
        }

        return view('livewire.settings.reports-admin', [
            'reports' => $records,
        ]);
    }
}
