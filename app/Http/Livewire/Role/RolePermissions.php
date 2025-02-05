<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;

class RolePermissions extends Component
{
    public $role;
    public $rolePermissions = [];
    public $permissions;

    public function mount($role)
    {
        $this->role = $role;

        $projectUsers = RolePermission::where([['project_id', '=', $this->project->id],
            ['status', '=', 'GRANTED']] )->get();
        foreach($projectUsers as $pUser){
            $this->projectUsers[$pUser->user_id]=true;
        }
    }

    public function render()
    {
        return view('livewire.role.role-permissions');
    }
}
