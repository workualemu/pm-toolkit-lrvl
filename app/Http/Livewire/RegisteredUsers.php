<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class RegisteredUsers extends Component
{
    public $records = [];

    protected $listeners = ['refreshUser' => '$refresh'
    ];

    public function editUser($user_id)
    {
        $this->emit('openUserModal', $user_id);
    }

    public function deleteUser($user_id)
    {
        $res=User::where('id', $user_id)->delete();
        $this->emit('refreshUser');
    }

    public function render()
    {
        $this->records = User::all();
        return view('livewire.registered-users');
    }
}

