<x-app-layout title="Reports" is-header-blur="true" sidebarToggle="false">
    <!-- Main Content Wrapper -->
    
    <livewire:settings.report-admin-modal />
    <livewire:settings.tag-modal />
    <livewire:settings.priority-modal />
    <livewire:settings.task-status-modal />
    <livewire:settings.template-projects-modal />
    
    <div class="flex-grow flex flex-col">          
        @livewire('settings.settings-page', ['project' => $project, 'title' => $page_title, 'type' => $page_type])
    </div>


</x-app-layout>