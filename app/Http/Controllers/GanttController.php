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
        logger($project_id);
        $user = Auth::user();

        // logger($user);
        logger($user->projects);
        // if (!$user->projects->where('id', $project_id)->exists()) {
        //     abort(403, 'Unauthorized access.');
        // }

        $tasks = Task::where('id', '!=', null)
                    ->where('project_id', $project_id)
                    ->orderBy('path')->get();
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
