<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Tasks extends Component
{
    public $showModal = false;

    public function newTask()
    {
        $user =  Auth::user();
        $projectId = $user->project_id;
        $project = Project::find($projectId);

        $this->emit('openTaskModal', null);
        $this->showModal = true;
    }
    
    public function getTasks(int $project_id)
    {
        $user =  Auth::user();
        if($project_id > 0){
            $user->project_id = $project_id;
            $user->save();
        }
        $projectId = $user->project_id;
        $project = Project::find($projectId);
        $tasks = [
            [
                'title'=>'Review previous census methods for material distribution',
                'description'=>'Review previous census methods for material distribution',
                'end_date'=>'Jun-10',
                'assigned_to'=>'WA',
                'labels'=>[
                    [
                        'label'=>'Logistics',
                        'color'=>'success'
                    ],
                    [
                        'label'=>'Finance',
                        'color'=>'warning'
                    ],
                    [
                        'label'=>'HR',
                        'color'=>'info'
                    ]
                ],
                'priority'=>[
                    'label'=>'High',
                    'color'=>'error'
                ],
                'status'=>'In progress',
                'kanban_order'=>30
            ],
            [
                'title'=>'Develop a strategy for material distribution',
                'description'=>'Develop a strategy for material distribution',
                'end_date'=>'Oct-10',
                'assigned_to'=>'YB',
                'labels'=>[
                    [
                        'label'=>'Logistics',
                        'color'=>'success'
                    ],
                    [
                        'label'=>'Finance',
                        'color'=>'warning'
                    ]
                ],
                'priority'=>[
                    'label'=>'Medium',
                    'color'=>'warning'
                ],
                'status'=>'Pending',
                'kanban_order'=>50
            ],
            [
                'title'=>'Prepare the specifications for packing and transporting',
                'description'=>'Prepare the specifications for packing and transporting',
                'end_date'=>'Jun-10',
                'assigned_to'=>'WA',
                'labels'=>[
                    [
                        'label'=>'HR',
                        'color'=>'info'
                    ]
                ],
                'priority'=>[
                    'label'=>'Low',
                    'color'=>'success'
                ],
                'status'=>'In progress',
                'kanban_order'=>20
            ]
        ];
        return view('livewire.tasks', compact('project', 'tasks'));
    }

    public function render()
    {
        return view('livewire.tasks');
    }
}
