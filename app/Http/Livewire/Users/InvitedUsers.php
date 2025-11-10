<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\Invitation;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class InvitedUsers extends Component
{
    use WithPagination;
    public $searchTerm;

    #[On('refreshInvitation')]
    public function onRefreshInvitation()
    {
        $this->dispatch('$refresh');
    }

    public function addNewInvitation()
    {
        $this->dispatch('openInvitationModal', null);
    }

    public function editInvitation($invitation_id)
    {
        $this->dispatch('openInvitationModal', $invitation_id);
    }

    #[On('deleteConfirmed')] 
    public function deleteConfirmed($id)
    {
        try{
            $selectedItem = Invitation::find($id);
            if($selectedItem->delete()){
                $this->dispatch('status-message', success: true, message: 'Invitation has been deleted successfully!');
            } else {
                $this->dispatch('status-message', success: false, message: 'Invitation cannot be deleted!');
            }
            $selectedItem->refresh();
        } catch (Exception $exception) {
            $this->dispatch('status-message', success: false, message: $exception->getMessage());
        }
        $this->dispatch('$refresh');
    }

    public function showLink(Invitation $invitation)
    {
        $this->dispatch('openInvitationModal', $invitation->id);
    }

    public function render()
    {
        $searchTerm = '%' . strtolower($this->searchTerm) . '%';

        $records = Invitation::where('status', 'Unused') 
            ->when($this->searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereRaw('LOWER(email) LIKE ?', [$searchTerm]);
                });
            })
            ->paginate(10);

        if ($records->isEmpty() && $this->getPage() > 1) {
            $this->resetPage(); 
        }

        return view('livewire.users.invited-users', [
            'records' => $records,
        ]);
    }
}
