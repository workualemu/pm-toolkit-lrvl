<div>
    <main class="main-content w-12/12">
    <x-status-message/>
    <x-app-partials.delete-confirmation />
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
        @elseif($page_type == 'TAG')
            @livewire('settings.tags')
        @elseif($page_type == 'PRIORITY')
            @livewire('settings.prioritys')
        @elseif($page_type == 'REPORT')
            @livewire('settings.reports-admin')
        @endif
    @endif
    </main>
</div>
