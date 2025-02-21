<div>
    <main class="main-content w-12/12">
        <x-status-message/>
        <x-app-partials.delete-confirmation />
        @if($project == null)
            <div
                class="flex items-center justify-between space-x-2 px-2 py-5 transition-all duration-[.25s]">
                <div class="flex items-center space-x-1">
                    <h3 class="text-lg font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                        {{ $page_title }}
                    </h3>
                </div>
            </div>
        @else
            @if($page_type == 'INVITATION')
                @livewire('users.invited-users')
            @elseif($page_type == 'USER')
                @livewire('users.registered-users')
            @elseif($page_type == 'ROLE')
                @livewire('users.roles')
            @endif
        @endif
    </main>
</div>