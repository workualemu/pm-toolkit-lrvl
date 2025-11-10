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
    public $guard_name = 'web';
    public $searchTerm = '';
    public $errorMessage = null;

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function updatedGuardName($value)
    {
        $this->assignedRoles = [];
        if ($this->selectedUser) {
            $this->selectedUser->load('roles');
            foreach ($this->selectedUser->roles->where('guard_name', $value) as $role) {
                $this->assignedRoles[$role->id] = true;
            }
        }
    }
    
    public function mount($user_id)
    {
        $this->selectedUser = User::find($user_id);
        $this->guard_name = config('auth.defaults.guard');

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
            $roles = Role::where('guard_name', $this->guard_name)
                ->whereIn('id', array_keys($this->assignedRoles))->get();

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
        $roles = Role::where('guard_name', $this->guard_name)
            ->when($this->searchTerm, function ($query) {
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->searchTerm) . '%']);
            })->get();
    
        return view('livewire.users.user-roles', [
            'roles' => $roles
        ]);
    }
}
