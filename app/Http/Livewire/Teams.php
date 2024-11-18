<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Team;

class Teams extends Component
{
    public $records = [];

    protected $listeners = ['refreshTeam' => '$refresh'
    ];

    public function addNewTeam()
    {
        $this->emit('openTeamModal', null);
    }

    public function editTeam($team_id)
    {
        $this->emit('openTeamModal', $team_id);
    }

    public function teamMembers($team_id)
    {
        $this->emit('openTeamModal', $team_id);
    }

    public function deleteTeam($team_id)
    {
        $res=Team::where('id', $team_id)->delete();
        $this->emit('refreshTeam');
    }

    public function render()
    {
        $this->records = Team::all();
        return view('livewire.teams');
    }
}
