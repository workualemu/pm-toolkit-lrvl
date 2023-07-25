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
        $this->report_id = $report_id;
        $this->render();
    }

    
    public function addNewReportParam()
    {
        $this->emit('openReportParamModal', $this->report_id, null);
    }

    public function editReportParam($param_id)
    {
        $this->emit('openReportParamModal', $this->report_id, $param_id);
    }

    public function mount()
    {
        $this->report = new Report();
    }

    public function render()
    {
        $this->params = ReportParam::getByReport($this->report_id)->get();
        return view('livewire.report-params');
    }
}
