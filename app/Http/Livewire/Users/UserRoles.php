<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRoles extends Component
{
    public $selectedUser;
    public $assignedRoles = [];
    public $searchTerm = '';
    public $errorMessage = null;

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }
    
    public function mount($user_id)
    {
        $this->selectedUser = User::find($user_id);

        if($this->selectedUser != null){
            $userRoles = $this->selectedUser->roles;
            foreach($userRoles as $rl){
                $this->assignedRoles[$rl->id]=true;
            }
        }
    }

    public function assignRoles($isSave)
    {
        if($isSave){
            $roles = Role::whereIn('id', array_keys($this->assignedRoles))->get();

            $assignRoles = [];
            foreach ($roles as $role) {
                if (!empty($this->assignedRoles[$role->id])) {
                    $assignRoles[] = $role->name; 
                }

                if ($role->name === 'Super Admin' && empty($this->assignedRoles[$role->id]) &&  $this->selectedUser->id === Auth::id()) {
                    $this->errorMessage = "You cannot revoke your own Super Admin role.";
                    $this->dispatch('closeUserRoles', -1, $this->errorMessage);
                    return;
                }
            }
            
            $this->selectedUser->syncRoles($assignRoles);
            $this->dispatch('closeUserRoles', 1, null);
        } else {
            $this->dispatch('closeUserRoles', 0, null);
        } 
    }

    public function render()
    {
        $roles = Role::when($this->searchTerm, function ($query) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->searchTerm) . '%']);
        })->get();
    
        return view('livewire.users.user-roles', [
            'roles' => $roles
        ]);
    }
}
