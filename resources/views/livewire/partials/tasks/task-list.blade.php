<div class="w-12/12 flex flex-col h-screen overflow-y-scroll p-10">
    <div class="card px-4 pt-2 pb-4">
    <div>
        @forelse($tasks as $task)
        <div  class="bg-blue-100">
            @livewire('task', ['task' => $task], key(crc32($task->id)))
        </div>
        @foreach ($task->children as $child)
            <div style="margin-left: 20px;" class="bg-blue-50">
                @livewire('task', ['task' => $child], key(crc32($child->id)))
            </div>
            @foreach ($child->children as $gchild)
                <div style="margin-left: 40px;">
                @livewire('task', ['task' => $gchild], key(crc32($gchild->id)))
                </div>
            @endforeach
        @endforeach
        @empty
        <div>
            <div colspan="6" class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-400">
                {{ __('There are no records to display') }}
            </div>
        </div>
        @endforelse
    </div>
    </div>
</div>