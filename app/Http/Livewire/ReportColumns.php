<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ReportColumn;
use App\Models\Report;

class ReportColumns extends Component
{
    public $report;

    public $columns = [];

    public $showModal = false;

    public function mount($report)
    {
        $this->report = $report;
    }

    public function render()
    {
        return view('livewire.report-columns');
    }
}
