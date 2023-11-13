<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\User;
use App\Models\UserProject;
use Illuminate\Support\Facades\Auth;

class ProjectUsers extends Component
{
    public $project;
    public $projectUsers = [];
    public $users;

    public function mount($project)
    {
        $this->project = $project;

        $projectUsers = UserProject::where([['project_id', '=', $this->project->id],
            ['status', '=', 'GRANTED']] )->get();
        foreach($projectUsers as $pUser){
            $this->projectUsers[$pUser->user_id]=true;
        }
    }

    public function assignUsers()
    {
        $user =  Auth::user();
        foreach($this->projectUsers as $key=>$pUser){
            if($pUser){
                $projectUser = UserProject::updateOrCreate(
                    ['user_id' => $key, 'project_id'=>$this->project->id],
                    ['status' => 'GRANTED', 'created_by'=>Auth::user()->id]);
            } else {
                $projectUser = UserProject::updateOrCreate(
                    ['user_id' => $key, 'project_id'=>$this->project->id],
                    ['status' => 'DENIED', 'created_by'=>Auth::user()->id]);
            }
            

        }

        redirect()->route('index');
    }

    public function render()
    {
        $this->users = User::whereHas('roles', function ($q) {
            $q->where('roles.name', '!=', 'Super Admin'); 
          })->get();

        // $this->projectUsers = [];
        // foreach($this->users as $user){
        //     $this->projectUsers[$user->id]=false;
        // }

        
        
        return view('livewire.project-users');
    }
}
