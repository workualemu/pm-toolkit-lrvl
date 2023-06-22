<div class="board-draggable relative flex max-h-full w-72 shrink-0 flex-col">
    <div class="board-draggable-handler flex items-center justify-between px-0.5 pb-3">
        <div class="flex items-center space-x-2">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-info/10 text-info">
                <i class="fa fa-spinner text-base"></i>
            </div>
            <h3 class="text-base text-slate-700 dark:text-navy-100">
                {{$kanbanList->value}}
            </h3>
        </div>

        <div x-data="usePopper({ placement: 'bottom-end', offset: 4 })" @click.outside="if(isShowPopper) isShowPopper = false"
            class="inline-flex">
            <button x-ref="popperRef" @click="isShowPopper = !isShowPopper"
                class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>
            </button>

            <template x-teleport="#x-teleport-target">
                <div x-ref="popperRoot" class="popper-root" :class="isShowPopper && 'show'">
                    <div
                        class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                        <ul>
                            <li>
                                <a href="#"
                                    class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Action</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Another
                                    Action</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Something
                                    else</a>
                            </li>
                        </ul>
                        <div class="my-1 h-px bg-slate-150 dark:bg-navy-500"></div>
                        <ul>
                            <li>
                                <a href="#"
                                    class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Separated
                                    Link</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </template>
        </div>
    </div>
    <div class="is-scrollbar-hidden relative space-y-2.5 overflow-y-auto p-0.5"
        x-init="Sortable.create($el, {
            animation: 200,
            group: 'board-cards',
            easing: 'cubic-bezier(0, 0, 0.2, 1)',
            direction: 'vertical',
            delay: 150,
            delayOnTouchOnly: true,
        })">

        @forelse($tasks as $task)
            @livewire('kanban-task', ['task' => $task], key(crc32($task)))
        @empty
        
        @endforelse

        <div class="card cursor-pointer shadow-sm">
            <div class="flex space-x-3 px-2.5 pb-2 pt-1.5">
                <div class="flex-1 space-y-2">
                    <p class="font-medium tracking-wide text-slate-600 dark:text-navy-100">
                        Review previous census methods for material distribution
                    </p>
                    <div class="flex flex-wrap space-x-1">
                        <div
                            class="badge space-x-1 bg-slate-150 py-1 px-1.5 text-slate-800 dark:bg-navy-500 dark:text-navy-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span> Sep 12</span>
                        </div>
                        <div
                            class="badge bg-secondary/10 py-1 px-1.5 text-secondary dark:bg-secondary-light/15 dark:text-secondary-light">
                            High
                        </div>
                        <div class="badge space-x-1 bg-info/10 py-1 px-1.5 text-info dark:bg-info/15">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>4/5</span>
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
                            <div class="avatar h-5 w-5 hover:z-10">
                                <div
                                    class="is-initial rounded-full bg-info text-tiny+ uppercase text-white ring-1 ring-white dark:ring-navy-700">
                                    yb
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

        <div class="card cursor-pointer shadow-sm">
            <div class="space-y-2 px-2.5 pb-2 pt-1.5">
                <div>
                    <div class="flex justify-between">
                        <p
                            class="font-medium tracking-wide text-slate-600 line-clamp-2 dark:text-navy-100">
                            Develop a strategy for distribution of census materials
                        </p>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="-mr-1.5 h-3.5 w-3.5 shrink-0 text-info" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-wrap space-x-1">
                    <div
                        class="badge space-x-1 bg-slate-150 py-1 px-1.5 text-slate-800 dark:bg-navy-500 dark:text-navy-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span> Nov 14</span>
                    </div>
                    <div class="badge bg-info/10 py-1 px-1.5 text-info dark:bg-info/15">
                        Low
                    </div>
                    <div class="badge space-x-1 bg-error/10 py-1 px-1.5 text-error dark:bg-error/15">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>1/5</span>
                    </div>
                </div>
                <div class="flex items-end justify-between pt-1">
                    <div class="flex flex-wrap -space-x-1.5">
                        <div class="avatar h-5 w-5 hover:z-10">
                            <div
                                class="is-initial rounded-full bg-info text-tiny+ uppercase text-white ring-1 ring-white dark:ring-navy-700">
                                mh
                            </div>
                        </div>

                        <div class="avatar h-5 w-5 hover:z-10">
                            <div
                                class="is-initial rounded-full bg-primary text-tiny+ uppercase text-white ring-1 ring-white dark:ring-navy-700">
                                bt
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card cursor-pointer shadow-sm">
            <div class="space-y-3 rounded-lg bg-success/10 px-2.5 pb-2 pt-1.5">
                <div>
                    <div class="flex justify-between">
                        <p class="font-medium tracking-wide text-success line-clamp-2">
                        Prepare the specifications for packing and transporting
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap space-x-1">
                    <div
                        class="badge space-x-1 bg-success/10 py-1 px-1.5 text-success dark:bg-success/15">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span> Oct 10</span>
                    </div>
                    <div class="badge bg-warning/10 py-1 px-1.5 text-warning dark:bg-warning/15">
                        medium
                    </div>
                    <div class="badge space-x-1 bg-error/10 py-1 px-1.5 text-error dark:bg-error/15">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>50%</span>
                    </div>
                </div>
                <div class="flex items-end justify-between pt-1">
                    <div class="flex flex-wrap -space-x-1.5">
                        <div class="avatar h-5 w-5 hover:z-10">
                            <div
                                class="is-initial rounded-full bg-info text-tiny+ uppercase text-white ring-1 ring-white dark:ring-navy-700">
                                mh
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
                        <span>0</span>
                    </div>
                </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="flex justify-center py-2">
        <button
            class="flex items-center justify-center space-x-2 font-medium text-slate-600 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span>New Task</span>
        </button>
    </div>
</div>
