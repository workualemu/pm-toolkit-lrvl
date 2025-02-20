<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use App\Mail\InvitationMail;
use Livewire\Attributes\Rule as LivewireRule;
use Livewire\Attributes\On;

class InvitedUsersModal extends Component
{
    public $invitation;
    public $showModal = false;
    public $roles =[];
    // public $role;

    #[LivewireRule('required|string|min:2')]
    public $email;
    public $role;

    #[On('openInvitationModal')]
    public function openInvitationModal($invitation_id)
    {
        $this->invitation = new Invitation();
        if($invitation_id > 0) {
            $this->invitation = Invitation::find($invitation_id);
        }
        
        $this->email = $this->invitation->email;
        $this->role = $this->invitation->role;
        $this->roles = Role::where('name', '!=', 'Super Admin')->get();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }


    public function submit()
    {
        $this->validate();
        $this->invitation->email = $this->email;
        $this->invitation->role = $this->role;
        try {
            $expiresAt = now()->addHours(72);
            $invitation = Invitation::create([
                'email' => $this->invitation->email,
                'link' => URL::temporarySignedRoute('register', $expiresAt, ['email' => $this->invitation->email]),
                'expires_at' => $expiresAt,
                'role' => $this->invitation->role,
            ]);

            Mail::to($invitation['email'])->send(new InvitationMail($invitation));

        } catch (Exception $exception) {
            $this->addError('email', $exception->getMessage());
        }

        
        $this->showModal = false;
        $this->dispatch('refreshInvitation');
    }

    public function resendEmail()
    {
        $this->validate();
        try {
            $expiresAt = now()->addHours(24);
            $this->invitation->update([
                'link' => URL::temporarySignedRoute('register', $expiresAt, ['email' => $this->invitation->email]),
                'expires_at' => $expiresAt,
                'role' => $this->invitation->role,
            ]);
            Mail::to($this->invitation['email'])->send(new InvitationMail($this->invitation));
            
        } catch (Exception $exception) {
            // $this->addError('email', $exception->getMessage());
        }
        $this->showModal = false;
        $this->dispatch('refreshInvitation');
    }

    public function mount()
    {
        $this->invitation = new Invitation();
    }

    public function render()
    {
        return view('livewire.users.invited-users-modal');
    }
}
