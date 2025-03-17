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
        $criteria = [['type'=>'where','column'=>'project_id', 'value'=>$project_id]];

        $searchTerm = request('search');
        if(!empty($searchTerm)){
            array_push($criteria, ['type' => 'whereRaw', 'column' => 'LOWER(tasks.title) LIKE ? OR LOWER(tasks.description) LIKE ?', 
                'values' => ['%' . strtolower($searchTerm) . '%',
                             '%' . strtolower($searchTerm) . '%'
                        ]]);
        }
        $tasks = Task::sortedTasks($criteria, 'path', 'asc');
        
        $tasks = $tasks->map(function($task) {
            $task->text = $task->title;
            if($task->level == 0) {
                $task->color = "#87CEEB";
            } elseif($task->level == 1){
                $task->color = "#87CEEB";
            } else{
                $task->color = "#87CEEB";
            }
            $task->progressColor = "#4169E1";
            
            return $task;
        });
        $links = Link::all()->map(function($link) {
            $link->color = "#FF8C00";
            return $link;
        });

        return response()->json([
            "tasks" =>$tasks,
            "links" => $links->all()
        ]);
    }

}
