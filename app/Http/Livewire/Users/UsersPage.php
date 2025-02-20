<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use ExcelReport;

class UsersPage extends Component
{
    public $page_title;
    public $page_type;

    public function mount($title, $type)
    {
        $user =  Auth::user();
        $this->page_title = $title;
        $this->page_type = $type;
    }

    public function render()
    {
        return view('livewire.users.users-page');
    }
}
