<x-app-layout title="Users" is-sidebar-open="false" is-header-blur="true" sidebarToggle="false">
    <!-- Main Content Wrapper -->
    
    <livewire:users.invited-users-modal />
    <livewire:users.role-modal />
    <livewire:teams-modal />
    <div class="flex-grow flex flex-col">          
        @livewire('users.users-page', ['title' => $page_title, 'type' => $page_type])
    </div>


</x-app-layout>
