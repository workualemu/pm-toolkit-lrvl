<div>
    <main class="main-content kanban-app">
        <!--header, title search, and filter block -->
        @livewire('partials.tasks.header', ['title'=>'Kanban board', 'showStatusFilter'=>false])
        
        <div class="flex h-[calc(100vh-8.5rem)] flex-grow flex-col  overflow-y-auto">
            <div x-init="Sortable.create($el, {
                animation: 200,
                easing: 'cubic-bezier(0, 0, 0.2, 1)',
                delay: 150,
                delayOnTouchOnly: true,
                draggable: '.board-draggable',
                handle: '.board-draggable-handler'
                })"
                class="kanban-scrollbar flex w-full items-start overflow-x-auto transition-all duration-[.25s]">
                
                <livewire:kanban-list :tasks="$tasks" :statuses="$statuses" :key="$taskIds" />
                
            </div>
        </div>
    </main>
</div>
