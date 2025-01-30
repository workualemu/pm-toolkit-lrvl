<div>
    <main class="main-content w-full">
    @if($project == null)
        <div
            class="flex items-center justify-between space-x-2 px-[var(--margin-x)] py-5 transition-all duration-[.25s]">
            <div class="flex items-center space-x-1">
                <h3 class="text-lg font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                    {{ __('Reports') }}
                </h3>
            </div>
        </div>
    @else
        <div
            class="flex items-center justify-between space-x-2 px-2 py-5 transition-all duration-[.25s]">
            <div class="flex items-center space-x-1">
                <h3 class="text-lg font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                    {{ __('Reports') }}
                </h3>
            </div>
            
        </div>
        @if($showReportUse)
        <div class="w-full">
            <div >
            <div
                    class="popper-box w-128 rounded-lg border border-slate-150 bg-white shadow-soft dark:border-navy-600 dark:bg-navy-700">
                    <div class="flex flex-col pt-2 pb-5 grid grid-cols-2 gap-4 sm:gap-5 lg:gap-6">
                        @foreach($reports as $report)
                            <a wire:click="generateReport({{$report->id}})"
                                href="#"
                                class="group flex items-center space-x-3 py-2 px-4 tracking-wide outline-none transition-all hover:bg-slate-100 focus:bg-slate-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-info text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2
                                        class="font-medium text-slate-700 transition-colors group-hover:text-primary group-focus:text-primary dark:text-navy-100 dark:group-hover:text-accent-light dark:group-focus:text-accent-light">
                                        {{ $report->title }}
                                    </h2>
                                    <div class="text-xs text-slate-400 line-clamp-1 dark:text-navy-300">
                                        {{ $report->description }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="w-full">
                <div>
                    @livewire('report-view', ['report_id' => $selectedReportID, 'results'=>$results])
                </div>
            </div>
        @endif
    @endif
    </main>
</div>
