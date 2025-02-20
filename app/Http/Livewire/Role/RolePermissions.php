<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use App\Models\Role;

class RolePermissions extends Component
{
    public $role;
    public $grantedPermissions = [];
    // public $permissions;
    public $searchTerm = '';


    public function mount($role_id)
    {
        $this->role = Role::find($role_id);

        if($this->role != null){
            $rolePermissions = $this->role->permissions;
            foreach($rolePermissions as $pm){
                $this->grantedPermissions[$pm->id]=true;
            }
        }
        
    }

    public function grantPermissions($isSave)
    {
        if ($isSave) {
            if (!$this->role) {
                $errorMessage = "Invalid role selection.";
                $this->dispatch('closeRolePermissions', -1, $errorMessage);
                return;
            }

            // Ensure grantedPermissions is an array before processing
            if (!is_array($this->grantedPermissions)) {
                $errorMessage = "Invalid permissions data.";
                $this->dispatch('closeRolePermissions', -1, $errorMessage);
                return;
            }

            try {
                // Fetch all permissions in one query to avoid multiple DB calls
                $permissionIds = array_keys($this->grantedPermissions);
                $permissions = Permission::whereIn('id', $permissionIds)->get()->keyBy('id');

                foreach ($this->grantedPermissions as $key => $value) {
                    if (!isset($permissions[$key])) {
                        continue; // Skip if permission not found
                    }

                    $permissionName = $permissions[$key]->name;

                    if ($value) {
                        $this->role->givePermissionTo($permissionName);
                    } else {
                        $this->role->revokePermissionTo($permissionName);
                    }
                }

                $this->dispatch('closeRolePermissions', 1, null);
            } catch (\Exception $e) {
                $errorMessage = "An error occurred while updating permissions.";
                $this->dispatch('closeRolePermissions', -1, $errorMessage);
            }
        } else {
            $this->dispatch('closeRolePermissions', 0, null);
        }
    }

    public function render()
    {
        $searchTerm = strtolower($this->searchTerm);
        $permissions = Permission::when($this->searchTerm, function ($query) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->searchTerm) . '%']);
        })->get();

        return view('livewire.role.role-permissions', [
            'permissions' => $permissions,
        ]);

    }
}
