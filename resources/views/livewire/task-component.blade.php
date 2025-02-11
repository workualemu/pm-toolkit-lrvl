<div 
    class="{{ $styles['padding'] }} {{ $styles['bgColor'] }}">
    <div class="border-b border-slate-150 py-3 dark:border-navy-500" 
        @click="openTaskRightModal(-1, {{ $task->id }}, -1)">
        <div class="flex items-center space-x-2 sm:space-x-3">
            <h2 class="cursor-pointer text-slate-600 line-clamp-1 dark:text-navy-100">
            <div wire:key="task-{{ $task->id }}">
                <h2>{{ $task->title }}</h2>
            </div>
            </h2>
        </div>
        <div class="mt-1 flex items-end justify-between">
            <div class="flex flex-wrap items-center font-inter text-xs">
                <p>
                    @if($task->start_date)
                        {{date('d-M-Y', strtotime($task->start_date))}}
                    @endif
                </p>
                &nbsp;&nbsp;to&nbsp;&nbsp;
                <p>
                    @if($task->end_date)
                        {{date('d-M-Y', strtotime($task->end_date))}}
                    @endif
                </p>
                <div class="m-1.5 w-px self-stretch bg-slate-600 dark:bg-navy-900"></div>
                <a href="#"
                    x-data="{ }"
                    @click.stop="Livewire.dispatch('filterByStatus', { statusId: '{{ $taskStatus?->id }}' })"
                >
                    <span class="flex items-center space-x-1 text-{{$taskStatus?->color}}-700">
                        <span>{{ $taskStatus?->value }}</span>
                    </span>
                </a>
                <div class="m-1.5 w-px self-stretch bg-slate-600 dark:bg-navy-500"></div>
                <span class="flex items-center space-x-1">
                    <a href="#"
                        x-data="{ }"
                        @click.stop="Livewire.dispatch('filterByAssignee', { assignedTo: '{{ $assignedTo?->id }}' })"
                    >
                        <span class="flex items-center space-x-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span>{{ $assignedTo?->name }}</span>
                        </span>
                    </a>
                </span>
                <div class="m-1.5 w-px self-stretch bg-slate-600 dark:bg-navy-500"></div>
                <div class="badge space-x-2.5 px-1 text-{{$taskPriority?->color}}-700">
                    <a href="#"
                        x-data="{ }"
                        @click.stop="Livewire.dispatch('filterByPriority', { priorityId: '{{ $taskPriority?->id }}' })"
                    >
                        <span class="flex items-center space-x-1 text-{{$taskPriority?->color}}-700">
                            <span>{{$taskPriority?->value}}</span>
                        </span>
                    </a>
                </div>
                <div class="m-1.5 w-px self-stretch bg-slate-600 dark:bg-navy-500"></div>
                <div class="flex items-center space-x-2 text-xs text-slate-400 dark:text-navy-300">
                    <div class="flex items-center space-x-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span>{{$task->getNumberOfComments()}}</span>
                    </div>
                </div>
                <div class="m-1.5 w-px self-stretch bg-slate-600 dark:bg-navy-500"></div>
                <div class="flex items-center space-x-2 text-xs text-slate-400 dark:text-navy-300">
                    @foreach($taskTags as $tag)
                        <div class="bg-{{$tag->color}}-600 badge text-white">
                            <a href="#"
                                x-data="{ }"
                                @click.stop="$wire.filterByTag({{ $tag->id }});"
                            >
                                <span>{{$tag->label}}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            @if($task->level == 0 && ($user->hasRole('admin') || $user->can('create activity')))
            <div class="flex items-center space-x-1">
                <button 
                    x-data=""
                    @click.stop="$wire.addNewTask({{$task->id }}, 1);"
                    class="relative group  h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 invisible opacity-0 group-hover:visible group-hover:opacity-100 bg-gray-800 text-white text-sm rounded py-1 px-2 transition-opacity duration-300 whitespace-nowrap">
                        {{ __('Add new activity') }}
                    </span>
                </button>
            </div>
            @elseif($task->level == 1 && ($user->hasRole('admin') || $user->can('create task')))
            <div class="flex items-center space-x-1">
                <button 
                    x-data=""
                    @click.stop="$wire.addNewTask({{$task->id }}, 2);"
                    class="relative group h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 invisible opacity-0 group-hover:visible group-hover:opacity-100 bg-gray-800 text-white text-sm rounded py-1 px-2 transition-opacity duration-300 whitespace-nowrap">
                        {{ __('Add new task') }}
                    </span>
                </button>
            </div>
            @elseif($task->level == 2)
            <div class="flex items-center space-x-1">
                <button 
                    x-data="{ isStarred: @entangle('isStarred') }"
                    @click.stop="isStarred =! isStarred; $wire.set('isStarred', isStarred); $wire.setStarred();"
                    :aria-pressed="isStarred"
                    class="relative group h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" :class="isStarred ? 'text-primary dark:text-accent' : 'text-current'" :fill="isStarred ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="1.5">
                        <path x-bind:d="isStarred ? 
                            'M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z' : 
                            'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'" 
                        />
                    </svg>
                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 invisible opacity-0 group-hover:visible group-hover:opacity-100 bg-gray-800 text-white text-sm rounded py-1 px-2 transition-opacity duration-300 whitespace-nowrap">
                        {{ __('Toggle starred task') }}
                    </span>
                </button>
            </div>
            @endif
        </div>
    </div>
    
</div>
