<div>
    <main class="main-content w-12/12">
    @if($project == null)
        <div
            class="flex items-center justify-between space-x-2 px-2 py-5 transition-all duration-[.25s]">
            <div class="flex items-center space-x-1">
                <h3 class="text-lg font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                    {{ $page_title }}
                </h3>
            </div>
        </div>
    @else
        <div
            class="flex items-center justify-between space-x-2  px-2 py-5 transition-all duration-[.25s]">
            <div class="flex items-center space-x-1">
                <h3 class="text-lg font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                    {{ $page_title }}
                </h3>
            </div>
        </div>
        <div class="flex items-center justify-between space-x-2 pl-2 pr-12 py-5 transition-all duration-[.25s]">
            @if($page_type == 'REPORT')
                <div class="w-full">
                    @livewire('settings.reports-admin')
                </div>
            @elseif($page_type == 'TAG')
                <div class="w-full">
                    @livewire('settings.tags')
                </div>
            @elseif($page_type == 'PRIORITY')
                <div class="w-full">
                    @livewire('settings.prioritys')
                </div>
            @elseif($page_type == 'STATUS')
                <div class="w-full">
                    @livewire('settings.task-statuses')
                </div>
            @else
                
            @endif
        </div>
    @endif
    </main>
</div>
