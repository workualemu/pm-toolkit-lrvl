<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\Role;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Roles extends Component
{
    use WithPagination;

    public $selectedRoleID = 0;
    public $showRolePermission = false;
    public $searchTerm;
    public $errorMessage = null;
    public $success = true;
    public $roles;

    public function addNewRole()
    {
        $this->dispatch('openRoleModal', null);
    }

    public function editRole($id)
    {
        $this->dispatch('openRoleModal', $id);
    }

    #[On('deleteConfirmed')] 
    public function deleteConfirmed($id)
    {
        try{
            $selectedItem = Role::find($id);
            if($selectedItem->delete()){
                $this->dispatch('status-message', success: true, message: 'Role has been deleted successfully!');
            } else {
                $this->dispatch('status-message', success: false, message: 'Role cannot be deleted!');
            }
            $selectedItem->refresh();
        } catch (Exception $exception) {
            $this->dispatch('status-message', success: false, message: $exception->getMessage());
        }
        $this->dispatch('$refresh');
    }

    public function filterRoles()
    {
        $this->dispatch('$refresh');
    }

    public function grantPermissions(Role $role)
    {
        $this->selectedRoleID = $role->id;
        $this->showRolePermission = true;
        $this->dispatch('$refresh');
    }

    #[On('closeRolePermissions')]
    public function onCloseRolePermissions($success, $message)
    {
        $this->showRolePermission = false;
        $this->errorMessage = $message;
        $this->success = $success;
        $this->dispatch('refreshRoles');
    }

    #[On('refreshRoles')]
    public function onRefreshRoles()
    {
        $this->dispatch('$refresh');
    }

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function render()
    {
        $records = Role::when($this->searchTerm, function ($query) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->searchTerm) . '%']);
        })->paginate(10);

        return view('livewire.users.roles', [
            'records' => $records,
        ]);
    }
}
