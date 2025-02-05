<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use App\Models\Role;
use Livewire\WithPagination;

class Roles extends Component
{
    use WithPagination;

    // public $records = [];
    public $selectedRoleID = 0;
    public $showRolePermission = false;

    protected $rules = [
        'role.name' => 'required|min:2',
    ];

    protected $listeners = ['refreshRoles' => '$refresh',
                            'closeRolePermissions' => 'onCloseRolePermissions'
    ];

    public function addNewRole()
    {
        $this->emit('openRoleModal', null);
    }

    public function editRole($id)
    {
        $this->emit('openRoleModal', $id);
    }

    public function deleteRole($id)
    {
        $res=Role::where('id', $id)->delete();
        $this->emit('refreshRoles');
    }

    public function grantPermissions(Role $role)
    {
        $this->selectedRoleID = $role->id;
        $this->showRolePermission = true;
        $this->emit('refreshRoles');
    }

    public function onCloseRolePermissions()
    {
        $this->showRolePermission = false;
        $this->emit('refreshRoles');
    }

    public function render()
    {
        return view('livewire.role.roles', [
            'records' => Role::paginate(5),
        ]);
    }
}
