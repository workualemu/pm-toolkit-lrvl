<x-app-layout title="Gantt Chart" is-header-blur="true">
    <!-- Main Content Wrapper -->
    @livewire('gantt', ['project_id' => $project->id])

</x-app-layout>
