<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ReportParam;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class ReportUseParam extends Component
{
    public $report_id;
    public $params = [];
    public $param_res;

    protected $listeners = ['renderUseParam' => 'renderUseParam'];
    
    public function generateReport()
    {
        dd($this->param_res);
    }

    public function renderUseParam($report_id)
    {
        
        $params = ReportParam::getByReport($report_id)->get();

        $params = $params->map( function($param){
            $param->operator = '=';
            $param->type = 'text';
            $param->options = null;

            if( $param->type != 'date' && $param->type != 'range'){
                $options = DB::table('tasks')
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
