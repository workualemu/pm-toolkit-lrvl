<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class TeamsModal extends Component
{
    public Team $team;
    public $showModal = false;
    public $readOnly = '';

    public $name;
    public $description;
    public $status;

    protected $rules = [
        'team.name' => 'required|min:2',
        'team.created_by' => 'required',
        'team.description'=>'',
        'team.status' => 'required'
    ];

    protected $listeners = ['openTeamModal' => 'openTeamModal'];

    public function openTeamModal($team)
    {
        if($team == 0){
            $this->team = new Team();
        } else {
            $this->team = Team::find($team);
        }
        
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function store()
    {
        $user = Auth::user();
        
        $this->team->created_by = $user->id;
        if($this->team->status == null){
            $this->team->status = 'ACTIVE';
        }
        try {
            $this->team->save();
            $this->team->refresh();
    
            $this->emit('refreshTeam');
            $this->showModal = false;
        } catch(Exception $e){
            dd($e->getMessage());
        }
    }

    public function mount()
    {
        $this->team = new Team();
        $user =  Auth::user();
        if(!$user->hasRole('Project Manager') && !$user->hasRole('Super Admin')){
            $this->readOnly = 'readonly';
        }
    }

    public function render()
    {
        return view('livewire.teams-modal');
    }
}
