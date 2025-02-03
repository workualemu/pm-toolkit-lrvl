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
use Spatie\SimpleExcel\SimpleExcelWriter;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        // $this->columns = ReportColumn::getByReport($this->report_id)->get();
        // if($this->columns->count() <= 0) {
        //     $this->columns = self::getAllColumns();
        // }

        $firstItem = $results[0];

        if ($firstItem) {
            $this->columns = array_keys(get_object_vars($firstItem));
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

    public function download(): StreamedResponse
    {
        $report = Report::find($this->report_id);
        $filename = str($report->title)->slug('-')->append('.xlsx')->toString();
        $writer = SimpleExcelWriter::streamDownload($filename)->addRows($this->data);
        return response()->streamDownload(fn() => $writer->close(), $filename);
    }

    public function exportToExcel()
    {

        $sortBy = 'title';

        $report = Report::find($this->report_id);

        $columns = array_merge(
            [[$report->title]],
            [['Print time: '.Carbon::now()]],
            [$this->columns->pluck('title')->toArray()]
        );

        return Excel::download(new ReportController(
            $this->results,
            $report->title,
            null,
            $columns
        ), $report->title.'.xlsx');
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
