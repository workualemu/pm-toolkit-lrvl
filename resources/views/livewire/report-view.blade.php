<div class="w-full sm:gap-5 lg:gap-6">
    <div
        class="flex items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5"
    >
    </div>
    @livewire('ag-grid', ['selectedReportTitle' => $selectedReportTitle, 'data'=>$results])
</div>