<div x-show="$store.global.isRightSidebarExpanded" @keydown.window.escape="$store.global.isRightSidebarExpanded = false">
    <div class="fixed inset-0 z-[150] bg-slate-900/60 transition-opacity duration-200"
        @click="$store.global.isRightSidebarExpanded = false" x-show="$store.global.isRightSidebarExpanded"
        x-transition:enter="ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
    <div class="fixed right-0 top-0 z-[151] h-full w-full sm:w-80">
        <div x-data="{ activeTab: 'tabHome' }"
            class="relative flex h-full w-full transform-gpu flex-col bg-white transition-transform duration-200 dark:bg-navy-750"
            x-show="$store.global.isRightSidebarExpanded" x-transition:enter="ease-out"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="ease-in" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full">
            <div class="flex items-center justify-between py-2 px-4">
                <p x-show="activeTab === 'tabHome'" class="flex shrink-0 items-center space-x-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-xs">{{ \Carbon\Carbon::now()->format('d M, Y') }}</span>
                </p>
                <p x-show="activeTab === 'tabActivity'" class="flex shrink-0 items-center space-x-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-xs">Activity</span>
                </p>

                <button @click="$store.global.isRightSidebarExpanded=false"
                    class="btn -mr-1 h-6 w-6 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div x-show="activeTab === 'tabHome'" x-transition:enter="transition-all duration-500 easy-in-out"
                x-transition:enter-start="opacity-0 [transform:translate3d(0,1rem,0)]"
                x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
                class="is-scrollbar-hidden overflow-y-auto overscroll-contain pt-1">
                
                

                <div class="mt-4 px-3">
                    <h2 class="text-xs+ font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                        Pinned Apps
                    </h2>

                    <div class="mt-3 flex space-x-3">
                        <a href="{{route('dashboards/crm-analytics')}}" class="w-12 text-center">
                            <div class="avatar h-10 w-10">
                                <div class="is-initial mask is-squircle bg-warning text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <p
                                class="mt-1.5 overflow-hidden text-ellipsis whitespace-nowrap text-xs text-slate-700 dark:text-navy-100">
                                {{ __('Tasks') }}
                            </p>
                        </a>
                        <a href="{{route('kanban')}}" class="w-12 text-center">
                            <div class="avatar h-10 w-10">
                                <div class="is-initial mask is-squircle bg-success text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                                    </svg>
                                </div>
                            </div>
                            <p
                                class="mt-1.5 overflow-hidden text-ellipsis whitespace-nowrap text-xs text-slate-700 dark:text-navy-100">
                                {{ __('Kanban') }}
                            </p>
                        </a>
                        <a href="{{route('apps/chat')}}" class="w-12 text-center">
                            <div class="avatar h-10 w-10">
                                <div class="is-initial mask is-squircle bg-info text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                            </div>
                            <p
                                class="mt-1.5 overflow-hidden text-ellipsis whitespace-nowrap text-xs text-slate-700 dark:text-navy-100">
                                {{ __('Gantt') }}
                            </p>
                        </a>
                        <a href="{{route('apps/filemanager')}}" class="w-12 text-center">
                            <div class="avatar h-10 w-10">
                                <div class="is-initial mask is-squircle bg-error text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                    </svg>
                                </div>
                            </div>
                            <p
                                class="mt-1.5 overflow-hidden text-ellipsis whitespace-nowrap text-xs text-slate-700 dark:text-navy-100">
                                {{ __('Files') }}
                            </p>
                        </a>
                        <a href="{{route('dashboards/banking-1')}}" class="w-12 text-center">
                            <div class="avatar h-10 w-10">
                                <div class="is-initial mask is-squircle bg-secondary text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                    </svg>
                                </div>
                            </div>
                            <p
                                class="mt-1.5 overflow-hidden text-ellipsis whitespace-nowrap text-xs text-slate-700 dark:text-navy-100">
                                {{ __('Reports') }}
                            </p>
                        </a>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="grid grid-cols-2 gap-3 px-3">
                        <div class="rounded-lg bg-slate-150 px-2.5 py-2 dark:bg-navy-600">
                            <div class="flex items-center justify-between space-x-1">
                                <p>
                                    <span class="text-lg font-medium text-slate-700 dark:text-navy-100">11.3</span>
                                    <span class="text-xs">hr</span>
                                </p>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4.5 w-4.5 text-secondary dark:text-secondary-light" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>

                            <p class="mt-0.5 text-tiny+ uppercase">{{ __('Project progress') }}</p>

                            <div class="progress mt-3 h-1.5 bg-secondary/15 dark:bg-secondary-light/25">
                                <div
                                    class="is-active relative w-8/12 overflow-hidden rounded-full bg-secondary dark:bg-secondary-light">
                                </div>
                            </div>

                            <div
                                class="mt-1.5 flex items-center justify-between text-xs text-slate-400 dark:text-navy-300">
                                <button
                                    class="btn -ml-1 h-6 w-6 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                                <span> 71%</span>
                            </div>
                        </div>
                        <div class="rounded-lg bg-slate-150 px-2.5 py-2 dark:bg-navy-600">
                            <div class="flex items-center justify-between space-x-1">
                                <p>
                                    <span class="text-lg font-medium text-slate-700 dark:text-navy-100">13</span>
                                    <span class="text-xs">/22</span>
                                </p>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-success"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>

                            <p class="mt-0.5 text-tiny+ uppercase">Completed tasks</p>

                            <div class="progress mt-3 h-1.5 bg-success/15 dark:bg-success/25">
                                <div class="relative w-6/12 overflow-hidden rounded-full bg-success"></div>
                            </div>

                            <div
                                class="mt-1.5 flex items-center justify-between text-xs text-slate-400 dark:text-navy-300">
                                <button
                                    class="btn -ml-1 h-6 w-6 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                                <span> 49%</span>
                            </div>
                        </div>
                    </div>
                </div>

                



                <div class="mt-4">
                    <h2 class="px-3 text-xs+ font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                        {{ __('Task status') }}
                    </h2>
                    <div class="grid grid-cols-2 gap-3 px-3">
                        <div class="rounded-lg bg-slate-150 px-2.5 py-2 dark:bg-navy-600">
                            <div class="flex items-center justify-between space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                    14
                                </p>
                                <svg xmlns="http://www.w3.org/2000/svg" stroke-width="1.5"
                                    class="h-5 w-5 text-primary dark:text-accent" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="mt-1 text-xs+">Pending</p>
                        </div>
                        <div class="rounded-lg bg-slate-100 p-3 dark:bg-navy-600">
                            <div class="flex justify-between">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                    36
                                </p>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                            <p class="mt-1 text-xs+">Completed</p>
                        </div>
                        <div class="rounded-lg bg-slate-100 p-3 dark:bg-navy-600">
                            <div class="flex justify-between">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                    143
                                </p>

                                <i class="fa fa-spinner text-base text-warning"></i>
                            </div>
                            <p class="mt-1 text-xs+">In Progress</p>
                        </div>
                        <div class="rounded-lg bg-slate-100 p-3 dark:bg-navy-600">
                            <div class="flex justify-between">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                    279
                                </p>

                                <i class="fa-solid fa-list-check text-base text-info"></i>
                            </div>
                            <p class="mt-1 text-xs+">Total</p>
                        </div>
                    </div>



                    
                </div>

                <div class="mt-4 rounded-lg border border-slate-150 p-3 dark:border-navy-600">
                    <div class="flex items-center space-x-3">
                        <div
                            class="timeline-item-point rounded-full bg-white text-warning dark:bg-navy-700">
                            <i class="fa fa-project-diagram text-tiny"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 dark:text-navy-300">
                                Census planning and preparation
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="progress mt-2 h-2 bg-slate-150 dark:bg-navy-500">
                            <div class="w-8/12 rounded-full bg-info"></div>
                        </div>
                        <p class="mt-2 text-right text-xs+ font-medium text-info dark:text-accent-light">
                            75%
                        </p>
                    </div>
                </div>

                <div class="mt-4 rounded-lg border border-slate-150 p-3 dark:border-navy-600">
                    <div class="flex items-center space-x-3">
                        <div
                            class="timeline-item-point rounded-full bg-white text-warning dark:bg-navy-700">
                            <i class="fa fa-project-diagram text-tiny"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 dark:text-navy-300">
                                GIS, mapping
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="progress mt-2 h-2 bg-slate-150 dark:bg-navy-500">
                            <div class="w-4/12 rounded-full bg-info"></div>
                        </div>
                        <p class="mt-2 text-right text-xs+ font-medium text-info dark:text-accent-light">
                            33%
                        </p>
                    </div>
                </div>

                <div class="mt-4 rounded-lg border border-slate-150 p-3 dark:border-navy-600">
                    <div class="flex items-center space-x-3">
                        <div
                            class="timeline-item-point rounded-full bg-white text-warning dark:bg-navy-700">
                            <i class="fa fa-project-diagram text-tiny"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 dark:text-navy-300">
                                Design of census questionnaires
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="progress mt-2 h-2 bg-slate-150 dark:bg-navy-500">
                            <div class="w-1/12 rounded-full bg-info"></div>
                        </div>
                        <p class="mt-2 text-right text-xs+ font-medium text-info dark:text-accent-light">
                            8%
                        </p>
                    </div>
                </div>

                <div class="mt-4 rounded-lg border border-slate-150 p-3 dark:border-navy-600">
                    <div class="flex items-center space-x-3">
                        <div
                            class="timeline-item-point rounded-full bg-white text-warning dark:bg-navy-700">
                            <i class="fa fa-project-diagram text-tiny"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 dark:text-navy-300">
                                Pilot census
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="progress mt-2 h-2 bg-slate-150 dark:bg-navy-500">
                            <div class="w-0/12 rounded-full bg-info"></div>
                        </div>
                        <p class="mt-2 text-right text-xs+ font-medium text-info dark:text-accent-light">
                            0%
                        </p>
                    </div>
                </div>

                <div class="mt-3 px-3">
                    <h2 class="text-xs+ font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                        Settings
                    </h2>
                    <div class="mt-2 flex flex-col space-y-2">
                        <label class="inline-flex items-center space-x-2">
                            <input x-model="$store.global.isDarkModeEnabled"
                                class="form-switch h-5 w-10 rounded-lg bg-slate-300 before:rounded-md before:bg-slate-50 checked:bg-slate-500 checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:bg-navy-400 dark:checked:before:bg-white"
                                type="checkbox" />
                            <span>Dark Mode</span>
                        </label>
                        <label class="inline-flex items-center space-x-2">
                            <input x-model="$store.global.isMonochromeModeEnabled"
                                class="form-switch h-5 w-10 rounded-lg bg-slate-300 before:rounded-md before:bg-slate-50 checked:bg-slate-500 checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:bg-navy-400 dark:checked:before:bg-white"
                                type="checkbox" />
                            <span>Monochrome Mode</span>
                        </label>
                    </div>
                </div>

                <div class="h-18"></div>
            </div>

            <div x-show="activeTab === 'tabActivity'" x-transition:enter="transition-all duration-500 easy-in-out"
                x-transition:enter-start="opacity-0 [transform:translate3d(0,1rem,0)]"
                x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
                class="is-scrollbar-hidden overflow-y-auto overscroll-contain pt-1">
                <div class="mx-3 flex flex-col items-center rounded-lg bg-slate-100 py-3 px-8 dark:bg-navy-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary dark:text-secondary-light"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                    <p class="mt-2 text-xs">Today</p>

                    <p class="text-lg font-medium text-slate-700 dark:text-navy-100">
                        6hr 22m
                    </p>

                    <div class="progress mt-3 h-2 bg-secondary/15 dark:bg-secondary-light/25">
                        <div
                            class="is-active relative w-8/12 overflow-hidden rounded-full bg-secondary dark:bg-secondary-light">
                        </div>
                    </div>

                    <button
                        class="btn mt-5 space-x-2 rounded-full border border-slate-300 px-3 text-xs+ font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-slate-400 dark:text-navy-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                        </svg>
                        <span> Download Report</span>
                    </button>
                </div>

                <ol class="timeline line-space mt-5 px-4 [--size:1.5rem]">
                    <li class="timeline-item">
                        <div
                            class="timeline-item-point rounded-full border border-current bg-white text-secondary dark:bg-navy-700 dark:text-secondary-light">
                            <i class="fa fa-history text-tiny"></i>
                        </div>
                        <div class="timeline-item-content flex-1 pl-4">
                            <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
                                <p class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0">
                                    Admin
                                </p>
                                <span class="text-xs text-slate-400 dark:text-navy-300">12 minute ago</span>
                            </div>
                            <p class="py-1">Task assigned to member aa</p>
                        </div>
                    </li>

                    <li class="timeline-item">
                        <div
                            class="timeline-item-point rounded-full border border-current bg-white text-secondary dark:bg-navy-700 dark:text-secondary-light">
                            <i class="fa fa-history text-tiny"></i>
                        </div>
                        <div class="timeline-item-content flex-1 pl-4">
                            <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
                                <p class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0">
                                    Worku
                                </p>
                                <span class="text-xs text-slate-400 dark:text-navy-300">12 minute ago</span>
                            </div>
                            <p class="py-1">Task status chsnged</p>
                        </div>
                    </li>
                    <li class="timeline-item">
                        <div
                            class="timeline-item-point rounded-full border border-current bg-white text-secondary dark:bg-navy-700 dark:text-secondary-light">
                            <i class="fa fa-history text-tiny"></i>
                        </div>
                        <div class="timeline-item-content flex-1 pl-4">
                            <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
                                <p class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0">
                                    Admin
                                </p>
                                <span class="text-xs text-slate-400 dark:text-navy-300">12 minute ago</span>
                            </div>
                            <p class="py-1">Commented on task Y</p>
                        </div>
                    </li>

                    
                    
                    
                    <li class="timeline-item">
                        <div
                            class="timeline-item-point rounded-full border border-current bg-white text-error dark:bg-navy-700">
                            <i class="fa fa-history text-tiny"></i>
                        </div>
                        <div class="timeline-item-content flex-1 pl-4">
                            <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
                                <p class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0">
                                    Admin
                                </p>
                                <span class="text-xs text-slate-400 dark:text-navy-300">a day ago</span>
                            </div>
                            <p class="py-1">The weekly report was uploaded</p>
                        </div>
                    </li>
                </ol>
                <div class="h-18"></div>
            </div>

            <div class="pointer-events-none absolute bottom-4 flex w-full justify-center">
                <div
                    class="pointer-events-auto mx-auto flex space-x-1 rounded-full border border-slate-150 bg-white px-4 py-0.5 shadow-lg dark:border-navy-700 dark:bg-navy-900">
                    <button @click="activeTab = 'tabHome'"
                        :class="activeTab === 'tabHome' && 'text-primary dark:text-accent'"
                        class="btn h-9 rounded-full py-0 px-4 hover:bg-slate-300/20 hover:text-primary focus:bg-slate-300/20 focus:text-primary active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:hover:text-accent dark:focus:bg-navy-300/20 dark:focus:text-accent dark:active:bg-navy-300/25">
                        <svg x-show="activeTab === 'tabHome'" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <svg x-show="activeTab !== 'tabHome'" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </button>
                    <button @click="activeTab = 'tabActivity'"
                        :class="activeTab === 'tabActivity' && 'text-primary dark:text-accent'"
                        class="btn h-9 rounded-full py-0 px-4 hover:bg-slate-300/20 hover:text-primary focus:bg-slate-300/20 focus:text-primary active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:hover:text-accent dark:focus:bg-navy-300/20 dark:focus:text-accent dark:active:bg-navy-300/25">
                        <svg x-show="activeTab ===  'tabActivity'" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd" />
                        </svg>
                        <svg x-show="activeTab !==  'tabActivity'" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
