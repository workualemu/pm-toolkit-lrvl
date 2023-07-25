<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ReportParam;
use Illuminate\Support\Facades\Auth;

class ReportParamModal extends Component
{
    public $showModal = false;
    public $param;
    public $report_id;
    public $table_columns = [];

    protected $rules = [
        'param.title' => 'required|min:2',
        'param.user_id' => 'required',
        'param.description'=>'',
        'param.db_column'=>'required',
        'param.type' => '',
        'param.ref_table' => '',
        'param.ref_column' => '',
        'param.report_id'=>'required'
    ];

    protected $listeners = ['openReportParamModal' => 'openModal'];

    public function openModal($report_id, $param_id)
    {
        $this->table_columns = \DB::getSchemaBuilder()->getColumnListing('tasks_view');
        $this->table_columns = collect($this->table_columns)->sort();

        $this->report_id = $report_id;

        $this->param = new ReportParam();
        if($param_id > 0){
            $this->param = ReportParam::find($param_id);
        }
        
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function store()
    {

        $user = Auth::user();
        $this->param->user_id = $user->id;

        $this->param->report_id = $this->report_id;
        $this->param->save();
        $this->param->refresh();

        $this->emit('refreshReportParams');
        $this->showModal = false;
        
    }

    public function render()
    {
        return view('livewire.report-param-modal');
    }
}
