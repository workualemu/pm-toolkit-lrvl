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
    public $searchTerm;


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

    public function filterPermissions()
    {
        $searchTerm = strtolower($this->searchTerm);
        $this->permissions = Permission::whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
                        ->get();

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
