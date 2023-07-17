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
        'report.db_table'=>'required',
        'report.published'=>'required',
        'report.sort_by' => '',
        'report.show_print_user' => '',
        'report.show_meta' => '',
        'report.show_print_date'=>''
    ];

    // ['title', 'db_table', 'sort_by', 'description', 'published', 'user_id',
    //     'show_meta', 'show_print_user', 'show_print_date'];
    protected $listeners = ['openReportModal' => 'openReportModal'];

    public function openReportModal($report_id)
    {
        $this->report = new Report();
        if($report_id > 0){
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

        $this->report->db_table = 'tasks';
        $this->report->save();
        $this->report->refresh();

        $this->showReportModal = false;
        // $this->emit('refreshTasks');
        
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
