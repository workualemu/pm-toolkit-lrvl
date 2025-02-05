<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use App\Models\Role;

class RolePermissions extends Component
{
    public $role;
    public $grantedPermissions = [];
    public $permissions;


    public function mount($role_id)
    {
        $this->role = Role::find($role_id);

        if($this->role != null){
            $rolePermissions = $this->role->permissions;
            foreach($rolePermissions as $pm){
                $this->grantedPermissions[$pm->id]=true;
            }
        }
        $this->permissions = Permission::all();
        
    }

    public function grantPermissions($isSave)
    {
        if($isSave){
            foreach($this->grantedPermissions as $key=>$value){
                $permission = Permission::find($key);
                if($value){
                    $this->role->givePermissionTo($permission->name);
                } else {
                    $this->role->revokePermissionTo($permission->name);
                }
            }
        }
        $this->emit('closeRolePermissions');
    }

    public function render()
    {
        return view('livewire.role.role-permissions');
    }
}
