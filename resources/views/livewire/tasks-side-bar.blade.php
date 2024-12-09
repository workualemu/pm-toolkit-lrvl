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
                <span> {{ __('New Task') }} </span>
            </button>
        </div>
        <ul class="mt-5 space-y-1.5 px-2 font-inter text-xs+ font-medium">
            <li>
                <a class="group flex {{ $bgMyAssigned }} space-x-2 rounded-lg p-2 tracking-wide text-slate-800 outline-none transition-all hover:bg-blue-200 focus:bg-blue-200 dark:text-navy-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600"
                    wire:click="myAssignedTasks()">
                    <svg width="28" height="24.5" viewBox="0 0 56 49" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="h-4.5 w-4.5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200">
                        <path d="M1.66162 48.25C1.66162 39.0588 12.5699 31.625 25.9999 31.625C28.7199 31.625 31.355 31.9337 33.82 32.5037M38.5799 38.75L41.3849 41.1012L47.4199 36.4225M40.1666 12.625C40.1666 19.1834 33.824 24.5 25.9999 24.5C18.1759 24.5 11.8333 19.1834 11.8333 12.625C11.8333 6.06662 18.1759 0.75 25.9999 0.75C33.824 0.75 40.1666 6.06662 40.1666 12.625ZM54.3333 38.75C54.3333 40.5312 53.7383 42.2175 52.69 43.6425C52.095 44.4975 51.33 45.2575 50.4516 45.875C48.4683 47.3712 45.8616 48.25 42.9999 48.25C38.8633 48.25 35.2649 46.3975 33.3099 43.6425C32.2616 42.2175 31.6666 40.5312 31.6666 38.75C31.6666 35.7575 33.3099 33.0738 35.9166 31.34C37.8716 30.0338 40.3366 29.25 42.9999 29.25C49.2616 29.25 54.3333 33.5012 54.3333 38.75Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>


                    <span>{{ __('My assigned tasks') }}</span>
                </a>
            </li>
            <li>
                <a class="group flex {{ $bgMyCommented }} space-x-2 rounded-lg p-2 tracking-wide text-slate-800 outline-none transition-all hover:bg-blue-200 focus:bg-blue-200 dark:text-navy-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600"
                    wire:click="myCommentedTasks()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="h-4.5 w-4.5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                    </svg>
                    <span>{{ __('My commented tasks') }}</span>
                </a>
            </li>
            <li>
                <a class="group flex {{ $bgMyReporting }} space-x-2 rounded-lg p-2 tracking-wide text-slate-800 outline-none transition-all hover:bg-blue-200 focus:bg-blue-200 dark:text-navy-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600"
                    wire:click="myReportingTasks()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="h-4.5 w-4.5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200" >
                        <path d="M20.5 11.3V7.04001C20.5 3.01001 19.56 2 15.78 2H8.22C4.44 2 3.5 3.01001 3.5 7.04001V18.3C3.5 20.96 4.96001 21.59 6.73001 19.69L6.73999 19.68C7.55999 18.81 8.80999 18.88 9.51999 19.83L10.53 21.18M8 7H16M9 11H15M17.6992 15.2803C17.9992 16.3603 18.8392 17.2003 19.9192 17.5003M18.211 14.7703L14.671 18.3103C14.531 18.4503 14.401 18.7103 14.371 18.9003L14.181 20.2503C14.111 20.7403 14.451 21.0803 14.941 21.0103L16.291 20.8203C16.481 20.7903 16.751 20.6603 16.881 20.5203L20.421 16.9803C21.031 16.3703 21.321 15.6603 20.421 14.7603C19.531 13.8703 18.821 14.1603 18.211 14.7703Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                    <span>{{ __('My reporting tasks') }}</span>
                </a>
            </li>
            <li>
                <a class="group flex {{ $bgStarred }} space-x-2 rounded-lg p-2 tracking-wide text-slate-800 outline-none transition-all hover:bg-blue-200 focus:bg-blue-200 dark:text-navy-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600"
                    wire:click="starredTasks()">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-4.5 w-4.5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:text-slate-500 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200" >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    <span>{{ __('Starred tasks') }}</span>
                </a>
            </li>
            <li>
                <a class="group flex space-x-2 rounded-lg {{ $bgAll }} p-2 tracking-wide text-slate-800 outline-none transition-all hover:bg-blue-200 focus:bg-blue-200 dark:text-navy-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600"
                    wire:click="allTasks()">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="h-4.5 w-4.5 text-slate-400 transition-colors group-hover:text-slate-500 group-focus:bg-warning/20 dark:text-navy-300 dark:group-hover:text-navy-200 dark:group-focus:text-navy-200"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-3 5h3m-6 0h.01M12 16h3m-6 0h.01M10 3v4h4V3h-4Z"/>
                    </svg>
                    <span>{{ __('All tasks') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
