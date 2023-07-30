<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ReportViewPage extends Component
{
    public $report_id;
    public $params;
    public $project;

    public function mount($report_id, $params)
    {
        $this->report_id = $report_id;
        $this->params = $params;

        $user =  Auth::user();
        $this->project = Project::find($user->project_id);
    }

    public function render()
    {
        return view('livewire.report-view-page');
    }
}
