<div class="flex space-x-2 h-screen p-2">
    @foreach($statuses as $status)
        <div class="w-[350px] min-w-[250px] flex flex-col bg-gray-100 rounded-lg border">
            <div class="flex justify-between">
                <div class="p-2 flex space-x-2 flex-grow ">
                    <div class="pt-1">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="{{ $status->color }}" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.85714 3H4.14286C3.51167 3 3 3.51167 3 4.14286V9.85714C3 10.4883 3.51167 11 4.14286 11H9.85714C10.4883 11 11 10.4883 11 9.85714V4.14286C11 3.51167 10.4883 3 9.85714 3Z" />
                        <path d="M9.85714 12.8999H4.14286C3.51167 12.8999 3 13.4116 3 14.0428V19.757C3 20.3882 3.51167 20.8999 4.14286 20.8999H9.85714C10.4883 20.8999 11 20.3882 11 19.757V14.0428C11 13.4116 10.4883 12.8999 9.85714 12.8999Z" fill="{{ $status->color }}" fill-opacity="0.3" />
                    </svg>
                    </div>
                    <h2 class="text-lg mb-2 capitalize text-center dark:bg-accent-light/15 dark:text-accent-light">{{ str_replace('_', ' ', $status->value) }}</h2>
                </div>
                <div class="p-2">
                    <div
                        class="badge h-5  rounded-full bg-{{ $status->color }}-300 px-1.5 text-black dark:bg-accent-light/15 dark:text-accent-light">
                        {{ count($tasks->where('task_status_id', $status->id)) }}
                    </div>
                </div>
            </div>
            <ul id="list-{{ $status->id }}"
                class="space-y-2 p-2 rounded-lg overflow-y-auto flex-grow max-h-full w-full border-t"
                x-data
                x-init="
                    Sortable.create($el, {
                        animation: 200,
                        group: 'kanban',
                        scroll: true, // Enable scrolling
                        scrollSensitivity: 50, // Start scrolling when near edges
                        scrollSpeed: 10, // Control scroll speed
                        onEnd: function(evt) {
                            let order = Array.from(evt.to.children).map(item => item.dataset.id);
                            let newStatus = evt.to.id.replace('list-', '');
                            $dispatch('updateTaskOrder', { order, status: newStatus });
                        }
                    });
                ">
                @foreach($tasks->where('task_status_id', $status->id) as $task)
                    <li class="border rounded-lg cursor-move shadow-sm w-full"
                        data-id="{{ $task->id }}">
                        <div class="card cursor-pointer shadow-sm bg-white w-full"
                            wire:click="openModal({{ $task->id }})" data-task="{{ $task->id }}">
                            <div class="flex space-x-3 px-2.5 pb-2 pt-1.5">
                                <div class="flex-1 space-y-2">
                                    <p class="font-small tracking-wide text-slate-600 dark:text-navy-100">
                                        {{$task->title}}
                                    </p>
                                    <div class="flex flex-wrap space-x-1">
                                        <div
                                            class="badge space-x-1 py-1 px-1.5 text-slate-800 dark:bg-navy-500 dark:text-navy-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>
                                                @if($task->end_date)
                                                    {{date('d-M-Y', strtotime($task->end_date))}}
                                                @endif
                                            </span>
                                        </div>
                                        <div
                                            class="badge py-1 px-1.5 text-{{$task->taskPriority?->color}}-700 dark:bg-secondary-light/15 dark:text-secondary-light">
                                            {{$task->taskPriority?->value}}
                                        </div>
                                    </div>
                                    <div class="flex items-end justify-between pt-1">
                                        <span class="badge space-x-1 py-1 px-1.5 text-slate-800 dark:bg-navy-500 dark:text-navy-100">
                                            <a href="#">
                                                <span class="flex items-center space-x-1 ">
                                                    <span>{{ $task->assignedTo?->name }}</span>
                                                </span>
                                            </a>
                                        </span>

                                        <div
                                            class="flex items-center space-x-2 text-xs text-slate-400 dark:text-navy-300">
                                            <div class="flex items-center space-x-0.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                                <span>{{$task->getNumberOfComments()}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>