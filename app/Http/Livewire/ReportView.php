<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ReportColumn;
use App\Models\ReportParam;
use App\Models\Task;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ReportController;
use Maatwebsite\Excel\Facades\Excel;
use ExcelReport;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReportView extends Component
{
    public $report_id;
    public $params;
    public $columns;
    public $results;

    public function mount($report_id, $results)
    {
        $this->report_id = $report_id;
        $this->results = $results;
        $this->columns = ReportColumn::getByReport($this->report_id)->get();
        if($this->columns->count() <= 0) {
            $this->columns = self::getAllColumns();
        }
    }

    public static function getAllColumns()
    {
        $cols = \DB::getSchemaBuilder()->getColumnListing('tasks_view');
        $cols = collect($cols);
        
        $cols = $cols->map(function ($col) {
            $column = $col;
            $col = (object) $col;
            $col->title = $column;
            $col->db_column = $column;
            $col->published = true;
            return $col;
        });

        return $cols;
    }

    public function exportToExcel()
    {
        // $where_clause = '';

        // foreach($this->params as $key => $param){
        //     if($params[$key]->type == 'Range' || $params[$key]->type == 'Date range'){
        //         $fromAvailable = false;
        //         if(isSet($param['from'])){
        //             $where_clause = ($where_clause == '' ? '':  $where_clause. ' AND '). $key. " >= '" . $param['from'] . "'";
        //             $fromAvailable = ' AND ';
        //         }
        //         if(isSet($param['to'])){
        //             $where_clause = ($where_clause == '' ? '':  $where_clause. ' AND ') . $key. " <= '" . $param['to'] . ($fromAvailable ? "'" : "'");
        //         }
        //     } elseif($params[$key]->type == 'Contain' ){
        //         $where_clause = ($where_clause == '' ? '':  $where_clause. ' AND '). $key. " IN (" . $param . ")";
        //     } else{
        //         $where_clause = ($where_clause == '' ? '':  $where_clause. ' AND '). $key. " = '" . $param . "'";
        //     }
        // }

        // $this->columns = ReportColumn::getByReport($this->report_id)->get();
        $sortBy = 'title';

        $report = Report::find($this->report_id);

        // $meta = [
        //     'All Tasks' => '',
        //     'Sort By' => $sortBy
        // ];

        // $queryBuilder = DB::table('tasks_view')
        //                 ->select($this->columns->pluck('db_column')->toArray()) // Do some querying..
        //                     ->whereRaw($where_clause)
        //                     ->orderBy($sortBy);

        // $this->results = $queryBuilder->get();
        $columns = array_merge(
            [[$report->title]],
            [['Print print: '.Carbon::now()]],
            [$this->columns->pluck('title')->toArray()]
        );

        return Excel::download(new ReportController(
            $this->results,
            $report->title,
            null,
            $columns
        ), 'export.xlsx');
    }

    public function showPDF()
    {
        $pdf = PDF::loadView('livewire.report-view', $this->columns->toArray(), $this->results);
     
        return $pdf->download('w3adda.pdf');

    }



    public function render()
    {
        return view('livewire.report-view');
    }
}
