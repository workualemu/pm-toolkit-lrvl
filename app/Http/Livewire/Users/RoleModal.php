<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\Role;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule as LivewireRule;

class RoleModal extends Component
{
    public $role;
    public $showModal = false;

    #[LivewireRule('required|string|min:2')]
    public $name;

    #[On('openRoleModal')]
    public function openRoleModal($id)
    {
        $this->role = new Role();
        if($id > 0) {
            $this->role = Role::find($id);
        }
        $this->name = $this->role->name;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function store()
    {
        $this->validate();
        $this->role->name = $this->name;
        try {
            $role = Role::updateOrCreate(
                ['id' => $this->role->id],
                ['name' => $this->role->name, 'guard_name'=>'web']);
            $this->dispatch('status-message', success: true, message: 'Role has been saved successfully!');
        } catch (Exception $exception) {
            $this->dispatch('status-message', success: false, message: $exception->getMessage());
        }

        $this->showModal = false;
        $this->dispatch('refreshRoles');
    }

    public function mount()
    {
        $this->role = new Role();
    }

    public function render()
    {
        return view('livewire.users.role-modal');
    }
}
