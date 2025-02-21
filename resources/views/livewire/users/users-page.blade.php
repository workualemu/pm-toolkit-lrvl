<div x-data="">
    <main class="main-content w-12/12">
        <x-status-message/>
        <x-app-partials.delete-confirmation />
        
        @if($page_type == 'INVITATION')
            @livewire('users.invited-users')
        @elseif($page_type == 'USER')
            @livewire('users.registered-users')
        @elseif($page_type == 'ROLE')
            @livewire('users.roles')
        @endif
    </main>
</div>