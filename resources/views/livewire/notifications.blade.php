<div>
    <button wire:click="$toggle('showNotifications')" class="relative">
      
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="bg-red-500 text-white px-2 py-1 text-xs rounded-full">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>

    @if($showNotifications)
        <div class="absolute bg-white shadow-lg p-3 w-64">
            <div class="flex justify-between">
                <span class="font-bold">Notifications</span>
                <button wire:click="markAsRead(null)" class="text-blue-500 text-sm">Mark All as Read</button>
            </div>

            @foreach($notifications as $notification)
                <div class="border-b p-2 flex justify-between">
                    <div>
                        <p>{{ $notification->data['message'] }}</p>
                        <small class="text-gray-500">Assigned by: {{ $notification->data['assigned_by'] }}</small>
                    </div>
                    <button wire:click="markAsRead('{{ $notification->id }}')" class="text-blue-500 text-xs">✔</button>
                </div>
            @endforeach

            {{ $notifications->links() }}
        </div>
    @endif
</div>