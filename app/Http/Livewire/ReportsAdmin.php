<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Report;

class ReportsAdmin extends Component
{

    public $reports = [];

    public $selectedReport;

    public $showReportModal = false;

    public function addNewReport()
    {
        $this->emit('openReportModal', null);
    }


    public function render()
    {
        $this->reports = Report::all();
        return view('livewire.reports-admin');
    }
}
