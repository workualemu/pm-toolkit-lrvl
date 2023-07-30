<x-app-layout title="Report view" is-header-blur="true">
    <!-- Main Content Wrapper -->
    
    <livewire:report-admin-modal />
    @livewire('report-view-page', ['report_id' => $report_id, 'params' => $params])

</x-app-layout>