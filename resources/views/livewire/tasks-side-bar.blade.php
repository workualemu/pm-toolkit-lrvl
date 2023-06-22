<div class="flex h-[calc(100%-4.5rem)] grow flex-col">
    <div class="is-scrollbar-hidden grow overflow-y-auto">
        <div class="mt-2 px-4">
            <button 
            wire:click="addNewTask()"
                class="btn w-full space-x-2 rounded-full border border-slate-200 py-2 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-500 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span> New Task </span>
            </button>
        </div>
        <ul class="mt-5 space-y-1.5 px-2 font-inter text-xs+ font-medium">
            <li>
                <a class="group flex {{ $bgMyAssigned }} space-x-2 rounded-lg p-2 tracking-wide text-slate-800 outline-none transition-all hover:bg-blue-200 focus:bg-blue-200 dark:text-navy-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600"
                    wire:click="myAssignedTasks()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>My assigned tasks</span>
                </a>
            </li>
            <li>
                <a class="group flex {{ $bgMyCommented }} space-x-2 rounded-lg p-2 tracking-wide text-slate-800 outline-none transition-all hover:bg-blue-200 focus:bg-blue-200 dark:text-navy-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600"
                    wire:click="myCommentedTasks()">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4.5 w-4.5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    <span>My commented tasks</span>
                </a>
            </li>
            <li>
                <a class="group flex {{ $bgMyReporting }} space-x-2 rounded-lg p-2 tracking-wide text-slate-800 outline-none transition-all hover:bg-blue-200 focus:bg-blue-200 dark:text-navy-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600"
                    wire:click="myReportingTasks()">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4.5 w-4.5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>My reporting tasks</span>
                </a>
            </li>
            <li>
                <a class="group flex space-x-2 rounded-lg {{ $bgAll }} p-2 tracking-wide text-slate-800 outline-none transition-all hover:bg-blue-200 focus:bg-blue-200 dark:text-navy-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600"
                    wire:click="allTasks()">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4.5 w-4.5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:bg-warning/20 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>All tasks</span>
                </a>
            </li>
            <li>
                <a class="group flex {{ $bgDeleted }} space-x-2 rounded-lg p-2 tracking-wide text-slate-800 outline-none transition-all hover:bg-blue-200 focus:bg-blue-200 dark:text-navy-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600"
                    wire:click="deletedTasks()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Deleted tasks</span>
                </a>
            </li>
        </ul>
        <div class="my-4 mx-4 h-px bg-slate-200 dark:bg-navy-500"></div>
        <div class="flex items-center justify-between px-4">
            <span class="text-xs font-medium uppercase">Priorities</span>
        </div>
        <ul class="mt-1 space-y-1.5 px-2 font-inter text-xs+ font-medium">
            @foreach($taskPriorities as $priority)
            <li>
                <a class="group flex space-x-2 rounded-lg p-2 tracking-wide outline-none transition-all hover:bg-blue-200 focus:bg-blue-200"
                    wire:click="filterTasksByPriority({{$priority->id}})">
                    <svg class="h-4.5 w-4.5 text-success" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 6H21M7 12H21M7 18H21" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M3 6H4M3 12H4M3 18H4" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span class="text-slate-800 dark:text-navy-100">{{$priority->value}}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
