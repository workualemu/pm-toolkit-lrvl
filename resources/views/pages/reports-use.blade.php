<x-app-layout title="Reports" is-header-blur="true">
    <!-- Main Content Wrapper -->
    
    <livewire:report-use-modal />
    @livewire('reports-use', ['project' => $project])

</x-app-layout>