<x-app-layout title="Reports" is-header-blur="true">
    <!-- Main Content Wrapper -->
    
    <livewire:invited-users-modal />
    @livewire('users-page', ['title' => $page_title, 'type' => $page_type])

</x-app-layout>