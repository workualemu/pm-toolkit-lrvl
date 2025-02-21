<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\On;

class RegisteredUsers extends Component
{

    public $searchTerm;
    public $selectedUserID = 0;
    public $showUserRole = false;
    public $errorMessage = null;
    public $success = 0;
    public $suspend;

    protected $listeners = ['refreshUser' => '$refresh',
                            'closeUserRoles' => 'onCloseUserRoles'
    ];


    public function inviteUser($user_id)
    {
        // $this->dispatch('openUserModal', $user_id);
    }

    public function editUser($user_id)
    {
        $this->dispatch('openUserModal', $user_id);
    }

    #[On('suspendConfirmed')] 
    public function suspendConfirmed($id)
    {
        logger('suspend');
        try{
            $selectedItem = User::find($id);
            $selectedItem->is_suspended = !$selectedItem->is_suspended;
            $selectedItem->save();
            $this->dispatch('status-message', success: true, message: 'Operation successful!');
            $selectedItem->refresh();
        } catch (Exception $exception) {
            $this->dispatch('status-message', success: false, message: $exception->getMessage());
        }
        $this->dispatch('$refresh');
    }


    public function deleteUser($user_id)
    {
        $res=User::where('id', $user_id)->delete();
        $this->dispatch('$refresh');
    }

    public function assignRoles(User $user)
    {
        $this->selectedUserID = $user->id;
        $this->showUserRole = true;
        $this->dispatch('refreshUser');
    }

    public function onCloseUserRoles($success, $message)
    {
        $this->showUserRole = false;
        $this->errorMessage = $message;
        $this->success = $success;
        $this->dispatch('refreshUser');
    }

    public function render()
    {
        $searchTerm = strtolower($this->searchTerm);

        $records = User::whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
                        ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $searchTerm . '%'])
                        ->orWhereHas('roles', function($query) use ($searchTerm) {
                            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
                        })
                        ->get();
        $records = $records->map(function($rec){
            $rec->suspend_action = $rec->is_suspended ? 'Unblock' : 'Block';
            return $rec;
        });

        return view('livewire.users.registered-users', [
            'records' => $records,
        ]);

        // return view('livewire.registered-users');
    }
}

