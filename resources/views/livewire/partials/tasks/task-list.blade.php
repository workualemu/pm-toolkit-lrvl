<div class="w-12/12 flex flex-col  p-10">
    <div class="card px-4">
        <div wire:key="tasks-container">
            <template wire:loading>
                <p class="text-gray-600">Loading tasks...</p>
            </template>
            @forelse($tasks as $task)
                <div wire:key="task-wrapper-{{ $task->id }}">
                    <livewire:task-component :$task :key="$task->id" />
                </div>
            @empty
                <div wire:key="empty-task-message">
                    <p class="text-gray-600">{{ __('No records found') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>