<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Team;
use App\Models\User;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Auth;

class TeamMembers extends Component
{
    public $team;
    public $members = [];
    public $users;

    public function mount($team)
    {
        $this->team = $team;

        $members = TeamMember::where([['team_id', '=', $this->team->id],
            ['status', '=', 'GRANTED']] )->get();
        foreach($members as $member){
            $this->members[$member->user_id]=true;
        }
    }

    public function assignUsers()
    {
        $user =  Auth::user();
        foreach($this->members as $key=>$pUser){
            if($pUser){
                $member = TeamMember::updateOrCreate(
                    ['user_id' => $key, 'team_id'=>$this->team->id],
                    ['status' => 'GRANTED', 'created_by'=>Auth::user()->id]);
            } else {
                $member = TeamMember::updateOrCreate(
                    ['user_id' => $key, 'team_id'=>$this->team->id],
                    ['status' => 'DENIED', 'created_by'=>Auth::user()->id]);
            }
        }

        return redirect()->back();
    }

    public function render()
    {
        $this->users = User::whereHas('roles', function ($q) {
            $q->where('roles.name', '!=', 'Super Admin'); 
          })->get();
  
        return view('livewire.team-members');
    }
}
