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
        @if($page_type == 'STATUS')
            @livewire('settings.task-statuses')
        @elseif($page_type == 'TEMPLATE')
            @livewire('settings.template-projects')
        @endif
        
        <div class="flex items-center justify-between space-x-2 pl-2 pr-2 transition-all duration-[.25s]">
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
            
                
            @endif
        </div>
    @endif
    </main>
</div>
