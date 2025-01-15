<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Link;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GanttController extends Controller
{
    public function get($project_id)
    {
        $user = Auth::user();

        if (empty($user->projects->where('id', $project_id))) {
            abort(403, 'Unauthorized access.');
        }

        $tasks = Task::where('id', '!=', null)
                    ->where('project_id', $project_id)
                    ->orderBy('path')->get();

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
