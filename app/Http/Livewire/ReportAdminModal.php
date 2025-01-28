<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportAdminModal extends Component
{
    public $report;
    public $showReportModal = false;

    protected $rules = [
        'report.title' => 'required|min:2',
        'report.user_id' => 'required',
        'report.description'=>'',
        'report.published'=>'required',
        'report.show_print_user' => '',
        'report.show_meta' => '',
        'report.show_print_date'=>'',
        'report.select_clause'=>'',
        'report.from_clause'=>'',
        'report.where_clause'=>'',
        'report.groupby_clause'=>'',
        'report.order_clause' => '',
        'report.having_clause'=>''
    ];

    protected $listeners = ['openReportModal' => 'openReportModal'];

    public function openReportModal($report_id)
    {
        $this->report = new Report();
        if($report_id > 0) {
            $this->report = Report::find($report_id);
        }

        $this->showReportModal = true;
    }

    public function closeModal()
    {
        $this->showReportModal = false;
    }

    public function store()
    {

        $user = Auth::user();
        $this->report->user_id = $user->id;

        if(!$user?->project_id){
            return "Invalid project";
        }
        
        $this->report->project_id = $user->project_id;
        $this->report->save();
        $this->report->refresh();

        $this->emit('refreshReport');
        $this->showReportModal = false;
    }

    public function mount()
    {
        $this->report = new Report();
    }

    public function render()
    {
        return view('livewire.report-admin-modal');
    }
}
