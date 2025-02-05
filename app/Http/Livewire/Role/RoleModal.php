<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use App\Models\Role;

class RoleModal extends Component
{
    public $role;
    public $showModal = false;

    protected $rules = [
        'role.name' => 'required|min:2',
    ];

    protected $listeners = ['openRoleModal' => 'openRoleModal'];

    public function openRoleModal($id)
    {
        $this->role = new Role();
        if($id > 0) {
            $this->role = Role::find($id);
        }
        
        // $this->roles = Role::where('name', '!=', 'Super Admin')->get();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function store()
    {
        $this->validate();
        try {
            $role = Role::create([
                'name' => $this->role->name,
                'guard_name' => 'web',
            ]);

        } catch (Exception $exception) {
            $this->addError('Role', $exception->getMessage());
        }

        $this->showModal = false;
        $this->emit('refreshRoles');
    }

    public function mount()
    {
        $this->role = new Role();
    }

    public function render()
    {
        return view('livewire.role.role-modal');
    }
}
