<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ReportColumn;
use App\Models\Report;

class ReportColumns extends Component
{
    public $report_id;
    public $columns = [];
    public $showModal = false;

    protected $listeners = ['renderReportColumn' => 'renderReportColumn',
                            'refreshReportColumns' => '$refresh'
    ];

    public function renderReportColumn($report_id)
    {
        $this->report_id = $report_id;
        $this->render();
    }

    public function addNewReportColumn()
    {
        $this->emit('openReportColumnModal', $this->report_id, null);
    }

    public function editReportColumn($column_id)
    {
        $this->emit('openReportColumnModal', $this->report_id, $column_id);
    }

    public function mount()
    {
        $this->report = new Report();
    }

    public function render()
    {
        $this->columns = ReportColumn::getByReport($this->report_id)->get();
        return view('livewire.report-columns');
    }

}
