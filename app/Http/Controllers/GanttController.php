<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Link;
use Illuminate\Support\Facades\DB;

class GanttController extends Controller
{
    public function get(){
        
        $tasks = new Task();
        $links = new Link();

        return response()->json([
            "tasks" => $tasks->all(), //select('id', 'text', 'type', 'start_date', 'duration', 'progress', 'parent')->get(),
            "links" => $links->all()
        ]);
    }
}
