<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    use WithPagination;
    public $showNotifications = false;
    protected $listeners = ['notification-added' => '$refresh'];

    public function getUnreadCountProperty()
    {
        return Auth::user()->unreadNotifications()->count();
    }

    public function markAsRead($notificationId)
    {
        if ($notificationId) {
            if ($notification = Auth::user()->notifications()->find($notificationId)) {
                $notification->markAsRead();
            }
        } else {
            Auth::user()->unreadNotifications->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        $this->markAsRead(null);
    }

    public function render()
    {
        return view('livewire.notifications', [
            'notifications' => Auth::user()->notifications()->latest()->paginate(5),
        ]);
    }
}
