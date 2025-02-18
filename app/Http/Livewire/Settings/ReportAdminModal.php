<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule as LivewireRule;

class ReportAdminModal extends Component
{
    public $report;
    public $showReportModal = false;

    #[LivewireRule('required|string|min:5')] 
    public $title;

    public $user_id;
    public $description;
    public $published;
    public $show_print_user;
    public $show_meta;
    public $show_print_date;

    #[LivewireRule('required')]
    public $select_clause;

    #[LivewireRule('required')]
    public $from_clause;

    public $where_clause;
    public $groupby_clause;
    public $order_clause;
    public $having_clause;

    #[On('openReportModal')]
    public function openReportModal($report_id)
    {
        $this->report = new Report();
        if($report_id > 0) {
            $this->report = Report::find($report_id);
        }
        $this->hidrate();
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

        if(!$user->project_id){
            return "Invalid project";
        }
        $this->dehidrate();
        $this->report->project_id = $user->project_id;
        $this->report->published = $this->report->published ?? false;
        $this->report->show_print_user = $this->report->show_print_user ?? false;
        $this->report->show_meta = $this->report->show_meta ?? false;
        $this->report->show_print_date = $this->report->show_print_date ?? false;
        $this->report->save();
        // $this->report->refresh();

        $this->dispatch('refreshReport');
        $this->showReportModal = false;
    }

    public function mount()
    {
        $this->report = new Report();
    }

    public function render()
    {
        return view('livewire.settings.report-admin-modal');
    }

    //------------------------------------------Private Methods ------------------------------------
    private function hidrate()
    {
        $this->title = $this->report->title;
        $this->description = $this->report->description;
        $this->published = $this->report->published;
        $this->show_print_user = $this->report->show_print_user;
        $this->show_meta = $this->report->show_meta;
        $this->show_print_date = $this->report->show_print_date;
        $this->select_clause = $this->report->select_clause;
        $this->from_clause = $this->report->from_clause;

        $this->where_clause = $this->report->where_clause;
        $this->groupby_clause = $this->report->groupby_clause;
        $this->order_clause = $this->report->order_clause;
        $this->having_clause = $this->report->having_clause;
    }

    private function dehidrate()
    {
        $this->report->title = $this->title;
        $this->report->description = $this->description;
        $this->report->published = $this->published;
        $this->report->show_print_user = $this->show_print_user;
        $this->report->show_meta = $this->show_meta;
        $this->report->show_print_date = $this->show_print_date;
        $this->report->select_clause = $this->select_clause;
        $this->report->from_clause = $this->from_clause;

        $this->report->where_clause = $this->where_clause;
        $this->report->groupby_clause = $this->groupby_clause;
        $this->report->order_clause = $this->order_clause;
        $this->report->having_clause = $this->having_clause;
    }
}
