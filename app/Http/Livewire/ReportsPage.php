<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use ExcelReport;

class ReportsPage extends Component
{
    public $project;

    public function generateReport()
    {

        // $columns = \DB::getSchemaBuilder()->getColumnListing('tasks');

        // $fromDate = $request->input('from_date');
        // $toDate = $request->input('to_date');
        // $sortBy = $request->input('sort_by');
        $sortBy = 'title';


        $title = 'Tasks'; // Report title

        $meta = [
            'All Tasks' => '',
            'Sort By' => $sortBy
        ];

        $queryBuilder = Task::select(['title', 'start_date', 'duration']) // Do some querying..
                            ->where('type', 'task')
                            ->orderBy($sortBy);

        $columns = [
            ['This is the title of the report'],
            ['Date of printing '],
            ['Title',
            'Start date',
            'Duration']
        ];


        return Excel::download(new ReportController(
            $queryBuilder->get(),
            'Tasks',
            null,
            $columns
        ), 'export.xlsx');
        // return Excel::download($queryBuilder->get(), 'export.xlsx');

        // ExcelReport::of($title, $meta, $queryBuilder, $columns)
        //     ->simple()
        //     ->download('report_test.xlsx');
    }

    public function mount($project_id)
    {
        $user =  Auth::user();
        $this->project = Project::find($user->project_id);

        $this->searchValue = ['project_id', $user->project_id];
    }

    public function render()
    {
        return view('livewire.reports-page');
    }
}
