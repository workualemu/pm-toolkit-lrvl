<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\Invitation;
use Livewire\Attributes\On;

class InvitedUsers extends Component
{
    public $records = [];

    public function addNewInvitation()
    {
        $this->dispatch('openInvitationModal', null);
    }

    public function editInvitation($invitation_id)
    {
        $this->dispatch('openInvitationModal', $invitation_id);
    }

    public function deleteInvitation($invitation_id)
    {
        $res=Invitation::where('id', $invitation_id)->delete();
        $this->dispatch('$refresh');
    }

    public function showLink(Invitation $invitation)
    {
        $this->dispatch('openInvitationModal', $invitation->id);
    }

    public function render()
    {
        $this->records = Invitation::where('status', '=', 'Unused')->get();
        return view('livewire.users.invited-users');
    }
}
