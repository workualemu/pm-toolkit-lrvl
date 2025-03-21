<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Config;
use Illuminate\Notifications\DatabaseNotification;

class TaskFrame extends Controller
{
    public function getTasks(int $project_id)
    {
        $user =  Auth::user();
        if($project_id > 0) {
            $user->project_id = $project_id;
            $user->save();
        }
        $project = Project::find($project_id);

        return view('pages/task-frame', compact('project'));
    }
}
