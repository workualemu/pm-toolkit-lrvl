<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use App\Models\Role;
use Livewire\WithPagination;


class Roles extends Component
{
    use WithPagination;

    public $selectedRoleID = 0;
    public $showRolePermission = false;
    public $searchTerm;
    public $errorMessage = null;
    public $success = 0;

    // protected $rules = [
    //     'role.name' => 'required|min:2',
    // ];

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

    public function filterRoles()
    {
        $this->emit('refreshRoles');
    }

    public function grantPermissions(Role $role)
    {
        $this->selectedRoleID = $role->id;
        $this->showRolePermission = true;
        $this->emit('refreshRoles');
    }

    public function onCloseRolePermissions($success, $message)
    {
        $this->showRolePermission = false;
        $this->errorMessage = $message;
        $this->success = $success;
        $this->emit('refreshRoles');
    }

    public function render()
    {
        $records = Role::when($this->searchTerm, function ($query) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->searchTerm) . '%']);
        })->paginate(10);
    
        return view('livewire.role.roles', [
            'records' => $records,
        ]);
    }
}
