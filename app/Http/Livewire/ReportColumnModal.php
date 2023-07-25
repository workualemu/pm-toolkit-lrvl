<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ReportColumn;
use Illuminate\Support\Facades\Auth;

class ReportColumnModal extends Component
{
    public $showModal = false;
    public $column;
    public $report_id;
    public $table_columns = [];

    protected $rules = [
        'column.title' => 'required|min:2',
        'column.user_id' => 'required',
        'column.description'=>'',
        'column.db_column'=>'required',
        'column.class' => '',
        'column.show_total' => 'required',
        'column.published' => 'required',
        'column.report_id'=>'required'
    ];

    protected $listeners = ['openReportColumnModal' => 'openModal'];

    public function openModal($report_id, $column_id)
    {
        $this->table_columns = \DB::getSchemaBuilder()->getColumnListing('tasks_view');
        $this->table_columns = collect($this->table_columns)->sort();
        
        $this->report_id = $report_id;
        $this->column = new ReportColumn();
        if($column_id > 0){
            $this->column = ReportColumn::find($column_id);
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
        $this->column->user_id = $user->id;
        $this->column->show_total= $this->column->show_total == null ? false : true;
        $this->column->published= $this->column->published == null ? false : true;

        $this->column->report_id = $this->report_id;
        $this->column->save();
        $this->column->refresh();

        $this->emit('refreshReportColumns');
        $this->showModal = false;
        
    }

    public function render()
    {
        return view('livewire.report-column-modal');
    }
}
