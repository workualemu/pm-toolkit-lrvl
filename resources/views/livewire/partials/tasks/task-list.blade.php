<div class="w-12/12 flex flex-col">
    
    <div class="card px-4">
        <template wire:loading>
            <p class="text-gray-600">Loading tasks...</p>
        </template>
        @forelse($tasks as $task)
            <livewire:task-component :task="$task" :key="'task-component-'.$task->id.now()" />
        @empty
            <div wire:key="empty-task-message">
                <p class="text-gray-600">{{ __('No records found') }}</p>
            </div>
        @endforelse
    </div>

    <livewire:task-right-popup />

</div>