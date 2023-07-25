<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ReportParam;
use App\Models\ReportColumn;
use App\Models\Task;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ReportController;
use Maatwebsite\Excel\Facades\Excel;
use ExcelReport;
use Carbon\Carbon;

class ReportUseParam extends Component
{
    public $report_id;
    public $params = [];
    public $param_res;

    protected $listeners = ['renderUseParam' => 'renderUseParam'];
    
    public function generateReport()
    {
        $where_clause = '';
        $params = $this->params->keyBy('db_column');

        foreach($this->param_res as $key => $param){
            if($params[$key]->type == 'Range' || $params[$key]->type == 'Date range'){
                $fromAvailable = false;
                if(isSet($param['from'])){
                    $where_clause = ($where_clause == '' ? '':  $where_clause. ' AND '). $key. " >= '" . $param['from'] . "'";
                    $fromAvailable = ' AND ';
                }
                if(isSet($param['to'])){
                    $where_clause = ($where_clause == '' ? '':  $where_clause. ' AND ') . $key. " <= '" . $param['to'] . ($fromAvailable ? "'" : "'");
                }
            } elseif($params[$key]->type == 'Contain' ){
                $where_clause = ($where_clause == '' ? '':  $where_clause. ' AND '). $key. " IN (" . $param . ")";
            } else{
                $where_clause = ($where_clause == '' ? '':  $where_clause. ' AND '). $key. " = '" . $param . "'";
            }
        }

        $columns = ReportColumn::getByReport($this->report_id)->get();
        $sortBy = 'title';

        $report = Report::find($this->report_id);

        $meta = [ 
            'All Tasks' => '',
            'Sort By' => $sortBy
        ];
       
        // $queryBuilder = Task::select($columns->pluck('db_column')->toArray()) // Do some querying..
        //             ->whereRaw($where_clause)
        //             ->orderBy($sortBy);
        $queryBuilder = DB::table('tasks_view')
                        ->select($columns->pluck('db_column')->toArray()) // Do some querying..
                            ->whereRaw($where_clause)
                            ->orderBy($sortBy);
                            
        $columns = array_merge( 
            [[$report->title]],
            [['Print print: '.Carbon::now()]],
            [$columns->pluck('title')->toArray()]);

        // $columns = [ 
        //     ['This is the title of the report'],
        //     ['Date of printing '],
        //     ['Title',
        //     'Start date',
        //     'Duration']
        // ];


        return Excel::download(new ReportController($queryBuilder->get(),
            'Tasks', null, $columns), 'export.xlsx');


    }

    public function renderUseParam($report_id)
    {
        
        $params = ReportParam::getByReport($report_id)->get();

        $params = $params->map( function($param){
            $param->operator = '=';
            $param->options = null;

            if( $param->type == 'Text'){
                $options = DB::table('tasks_view')
                    ->select($param->db_column)->distinct()->get();
                if($options->count() < 20){
                    $param->options = $options;
                    $param->type = 'select';
                }
            }
            return $param;
        });
        if($params == null){
            $params =[];
        }
        $this->params = $params;
        $this->report_id = $report_id;
        $this->render();
    }

    public function render()
    {
        return view('livewire.report-use-param');
    }
}
