<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ReportParam;
use App\Models\Report;

class ReportParams extends Component
{
    public $report_id;

    public $params = [];

    public $showModal = false;

    protected $listeners = ['renderReportParam' => 'renderReportParam',
                            'refreshReportParams' => '$refresh'
    ];
    
    public function renderReportParam($report_id)
    {
        // dd('renderReportParam');
        $this->report_id = $report_id;
        $this->render();
    }

    public function addNewReportParam()
    {
        $this->emit('openReportParamModal', $this->report_id, null);
    }

    public function mount()
    {
        $this->report = new Report();
    }

    public function render()
    {
        $this->params = ReportParam::getByReport($this->report_id)->get();
        // dd($this->params);
        return view('livewire.report-params');
    }
}
