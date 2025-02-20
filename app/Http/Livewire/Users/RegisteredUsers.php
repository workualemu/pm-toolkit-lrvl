<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\User;

class RegisteredUsers extends Component
{

    public $searchTerm;
    public $selectedUserID = 0;
    public $showUserRole = false;
    public $errorMessage = null;
    public $success = 0;

    protected $listeners = ['refreshUser' => '$refresh',
                            'closeUserRoles' => 'onCloseUserRoles'
    ];



    public function editUser($user_id)
    {
        $this->dispatch('openUserModal', $user_id);
    }

    public function deleteUser($user_id)
    {
        $res=User::where('id', $user_id)->delete();
        $this->dispatch('$refresh');
    }

    public function assignRoles(User $user)
    {
        $this->selectedUserID = $user->id;
        $this->showUserRole = true;
        $this->dispatch('refreshUser');
    }

    public function onCloseUserRoles($success, $message)
    {
        $this->showUserRole = false;
        $this->errorMessage = $message;
        $this->success = $success;
        $this->dispatch('refreshUser');
    }

    public function render()
    {
        $searchTerm = strtolower($this->searchTerm);
        // $permissions = Permission::when($this->searchTerm, function ($query) {
        //     $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->searchTerm) . '%']);
        // })->get();

        $records = User::whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
                        ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $searchTerm . '%'])
                        ->orWhereHas('roles', function($query) use ($searchTerm) {
                            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
                        })
                        ->get();

        return view('livewire.users.registered-users', [
            'records' => $records,
        ]);

        // return view('livewire.registered-users');
    }
}

