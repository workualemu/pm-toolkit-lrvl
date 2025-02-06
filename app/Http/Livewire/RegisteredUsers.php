<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class RegisteredUsers extends Component
{
    public $records = [];
    public $searchTerm;

    protected $listeners = ['refreshUser' => '$refresh'
    ];

    public function mount(){
        $this->records = User::with('roles')->get();
    }

    public function editUser($user_id)
    {
        $this->emit('openUserModal', $user_id);
    }

    public function deleteUser($user_id)
    {
        $res=User::where('id', $user_id)->delete();
        $this->emit('refreshUser');
    }

    public function filterUsers()
    {
        $searchTerm = strtolower($this->searchTerm);

        $this->records = User::whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
                        ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $searchTerm . '%'])
                        ->orWhereHas('roles', function($query) use ($searchTerm) {
                            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
                        })
                        ->get();
    }

    public function render()
    {
        return view('livewire.registered-users');
    }
}

