<div class="card cursor-pointer shadow-sm"
    wire:click="openModal({{ $task->id }} )">
    <div class="flex space-x-3 px-2.5 pb-2 pt-1.5">
        <div class="flex-1 space-y-2">
            <p class="font-medium tracking-wide text-slate-600 dark:text-navy-100">
                {{$task->title}}
            </p>
            <div class="flex flex-wrap space-x-1">
                <div
                    class="badge space-x-1 bg-slate-150 py-1 px-1.5 text-slate-800 dark:bg-navy-500 dark:text-navy-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span> 
                        @if($task->planned_end_date)
                            {{date('d-M-Y', strtotime($task->planned_end_date))}}
                        @endif
                    </span>
                </div>
                <div
                    class="badge py-1 px-1.5 text-{{$task->task_priority->color}} dark:bg-secondary-light/15 dark:text-secondary-light">
                    {{$task->task_priority->value}}
                </div>
            </div>
            <div class="flex items-end justify-between pt-1">
                <div class="flex flex-wrap -space-x-1.5">
                    <div class="avatar h-5 w-5 hover:z-10">
                        <div
                            class="is-initial rounded-full bg-info text-tiny+ uppercase text-white ring-1 ring-white dark:ring-navy-700">
                            wa
                        </div>
                    </div>
                </div>
                <div
                    class="flex items-center space-x-2 text-xs text-slate-400 dark:text-navy-300">
                    <div class="flex items-center space-x-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span>3</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
