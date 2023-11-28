<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use App\Mail\InvitationMail;

class InvitedUsersModal extends Component
{
    public $invitation;
    public $showModal = false;
    public $roles =[];
    // public $role;

    protected $rules = [
        'invitation.email' => 'required|min:2',
        'invitation.role' => '',
    ];

    protected $listeners = ['openInvitationModal' => 'openInvitationModal'];

    public function openInvitationModal($invitation_id)
    {
        $this->invitation = new Invitation();
        if($invitation_id > 0) {
            $this->invitation = Invitation::find($invitation_id);
        }
        
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
        $this->emit('refreshInvitation');
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
        $this->emit('refreshInvitation');
    }

    public function mount()
    {
        $this->invitation = new Invitation();
    }

    public function render()
    {
        return view('livewire.invited-users-modal');
    }
}
