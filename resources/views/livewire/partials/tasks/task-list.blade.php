<div class="w-12/12 flex flex-col  p-10">
    <div class="card px-4">
        <div>
            @forelse($tasks as $task)
                <div>
                    @livewire('task-component', ['task' => $task], key(crc32($task->id)))
                </div>
            @empty
            <div>
                <div colspan="6" class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-600">
                    {{ __('There are no records to display') }}
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>