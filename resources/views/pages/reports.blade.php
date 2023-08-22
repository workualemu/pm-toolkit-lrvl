<x-app-layout title="Reports" is-header-blur="true">
    <!-- Main Content Wrapper -->
    
    <livewire:report-admin-modal />
    <livewire:report-param-modal />
    <livewire:report-column-modal />
    <livewire:tag-modal />
    <livewire:priority-modal />
    <livewire:task-status-modal />
    @livewire('reports-page', ['project_id' => $project->id, 'title' => $page_title, 'type' => $page_type])

</x-app-layout>