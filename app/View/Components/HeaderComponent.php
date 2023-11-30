<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HeaderComponent extends Component
{
    public User $user;
    public Project $project;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount()
    {
        // dd('test');
        $this->user = Auth::user();
        $this->project = Project::find($this->user->project_id);
    }

    public function toggleRead($id)
    {
        $notification = $this->user->notifications()->where('id', $id)->first();

        if(isset($notification)){
            if($notification->read()){
                $notification->markAsUnread();
            } else {
                $notification->markAsRead();
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('livewire.header-component');
    }
}
