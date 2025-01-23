<x-app-layout title="Reports" is-header-blur="true" sidebarToggle="false">
    <!-- Main Content Wrapper -->
    
    <livewire:report-admin-modal />
    <livewire:tag-modal />
    <livewire:priority-modal />
    <livewire:task-status-modal />
    
    <div class="flex-grow flex flex-col">          
        @livewire('reports-page', ['project' => $project, 'title' => $page_title, 'type' => $page_type])
    </div>


</x-app-layout>