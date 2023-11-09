<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Invitation;

class InvitedUsers extends Component
{
    public $records = [];

    protected $listeners = ['refreshInvitation' => '$refresh'
    ];

    public function addNewInvitation()
    {
        $this->emit('openInvitationModal', null);
    }

    public function editInvitation($invitation_id)
    {
        $this->emit('openInvitationModal', $invitation_id);
    }

    public function deleteInvitation($invitation_id)
    {
        $res=Invitation::where('id', $invitation_id)->delete();
        $this->emit('refreshInvitation');
    }

    public function showLink(Invitation $invitation)
    {
        $this->emit('openInvitationModal', $invitation->id);
    }

    public function render()
    {
        $this->records = Invitation::where('status', '=', 'Unused')->get();
        return view('livewire.invited-users');
    }
}
