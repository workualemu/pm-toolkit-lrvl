<div class="relative" x-data="{ open: @entangle('showNotifications') }">
    <!-- <button @click="open = !open" class="relative flex items-center gap-2 rounded-full bg-white px-3 py-2 text-slate-600 shadow-sm hover:text-primary dark:bg-navy-700 dark:text-navy-100">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span class="text-xs uppercase tracking-wide text-slate-400 dark:text-navy-200">Notifications</span>
        <span class="badge rounded-full bg-primary/10 px-2 text-sm font-semibold text-primary dark:bg-accent/20 dark:text-accent-light">
            {{ $this->unreadCount }}
        </span>
    </button> -->

    <div x-cloak x-show="open" x-transition class="absolute right-0 z-50 mt-3 w-80 rounded-2xl border border-slate-150 bg-white shadow-2xl dark:border-navy-600 dark:bg-navy-700">
        <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3 dark:border-navy-600">
            <div>
                <p class="text-sm font-semibold text-slate-700 dark:text-navy-50">Notifications</p>
                <p class="text-xs text-slate-400 dark:text-navy-200">Keep up with project activity</p>
            </div>
            <button wire:click="markAllAsRead" class="text-xs font-medium text-primary hover:text-primary-focus dark:text-accent-light">
                Mark all read
            </button>
        </div>
        <div class="max-h-80 space-y-2 overflow-auto px-4 py-3">
            @forelse ($notifications as $notification)
                <div class="rounded-xl border border-slate-100 px-3 py-2 text-sm dark:border-navy-600 @if(is_null($notification->read_at)) bg-primary/5 dark:bg-accent/10 @endif">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="font-medium text-slate-700 dark:text-navy-50">{{ $notification->data['title'] ?? 'Notification' }}</p>
                            <p class="text-xs text-slate-400 dark:text-navy-200">{{ $notification->data['description'] ?? $notification->data['message'] ?? '' }}</p>
                        </div>
                        <button wire:click="markAsRead('{{ $notification->id }}')" class="text-xs text-primary hover:text-primary-focus dark:text-accent-light">
                            @if(is_null($notification->read_at)) Mark read @else View @endif
                        </button>
                    </div>
                    <span class="text-[11px] text-slate-400 dark:text-navy-200">{{ $notification->created_at->diffForHumans() }}</span>
                </div>
            @empty
                <div class="rounded-xl border border-dashed border-slate-200 px-3 py-4 text-center text-xs text-slate-400 dark:border-navy-600 dark:text-navy-200">
                    You're all caught up! No notifications right now.
                </div>
            @endforelse
        </div>
        <div class="border-t border-slate-100 px-4 py-2 text-right text-xs text-slate-400 dark:border-navy-600 dark:text-navy-200">
            {{ $notifications->links('vendor.pagination.simple-tailwind') }}
        </div>
    </div>
</div>
