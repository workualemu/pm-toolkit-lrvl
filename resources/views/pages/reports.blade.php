<x-app-layout title="Reports" is-header-blur="true">
    <!-- Main Content Wrapper -->
    
    <livewire:report-admin-modal />
    <livewire:report-param-modal />
    <livewire:report-column-modal />
    @livewire('reports-page', ['project_id' => $project->id])

</x-app-layout>