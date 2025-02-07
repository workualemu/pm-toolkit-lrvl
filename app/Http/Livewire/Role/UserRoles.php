<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRoles extends Component
{
    public $selectedUser;
    public $assignedRoles = [];
    // public $roles;
    public $searchTerm = '';
    public $errorMessage = null;

    public function mount($user_id)
    {
        $this->selectedUser = User::find($user_id);

        if($this->selectedUser != null){
            $userRoles = $this->selectedUser->roles;
            foreach($userRoles as $rl){
                $this->assignedRoles[$rl->id]=true;
            }
        }
        // $this->roles = Role::all();
        
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
                    $this->emit('closeUserRoles', -1, $this->errorMessage);
                    return;
                }
            }
            
            $this->selectedUser->syncRoles($assignRoles);
            $this->emit('closeUserRoles', 1, null);
        } else {
            $this->emit('closeUserRoles', 0, null);
        } 
    }

    public function render()
    {
        $roles = Role::when($this->searchTerm, function ($query) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->searchTerm) . '%']);
        })->paginate(10);
    
        return view('livewire.role.user-roles', [
            'records' => $records,
        ]);

        return view('livewire.role.user-roles');
    }
}
