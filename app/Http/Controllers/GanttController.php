<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Link;
use Illuminate\Support\Facades\DB;

class GanttController extends Controller
{
    public function get()
    {
        $tasks = Task::where('id', '!=', null)->orderBy('path')->get();
        // $tasks = Task::where($this->searchValue)->orderBy('list_order', 'asc')->get();

        $tasks = $tasks->map(function($task) {
            $task->text = $task->title;
            return $task;
        });
        $links = new Link();

        return response()->json([
            "tasks" =>$tasks,
            "links" => $links->all()
        ]);
    }
}
