<div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
    <div>
        <div class="flex items-center justify-between">
            
            <div>
                <button wire:click="addNewReport()"
                    class="border-b border-dotted border-current pb-0.5 font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70"
                >
                    {{ __('Add new report') }}
                </button>
            </div>

        </div>

        <div class="card mt-3">
            <div
                class="is-scrollbar-hidden min-w-full overflow-x-auto"
                x-data="pages.tables.initExample1"
            >
                <table class="is-hoverable w-full text-left">
                    <thead>
                        <tr>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                            >
                                {{ __('Title') }}
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                            >
                                {{ __('Sort by') }}
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                            >
                                {{ __('Published') }}
                            </th>
                            <th
                                class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                            >
                                {{ __('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports AS $index=>$report)
                            <tr wire:click="updateParamColumn({{$report->id}})"
                                @if($report->id == $selectedReportId)
                                    class="bg-blue-100 border-y border-transparent border-b-slate-200 dark:border-b-navy-500"
                                @else
                                    class="bg-white border-y border-transparent border-b-slate-200 dark:border-b-navy-500"
                                @endif
                            >
                                
                                <td
                                    class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100 lg:px-5"
                                >
                                    {{$report->title}}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100 lg:px-5"
                                >
                                {{$report->sort_by}}
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-3 sm:px-5"
                                >
                                    <label class="inline-flex items-center space-x-2">
                                        <input disabled
                                            class="form-switch h-5 w-10 rounded-lg bg-slate-300 before:rounded-md before:bg-slate-50 checked:!bg-info checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:before:bg-white"
                                            type="checkbox"
                                            @if($report->published) 
                                                checked
                                            @endif
                                        />
                                    </label>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5 relative">
                                    <div class="flex justify-center space-x-2">
                                        <button wire:click="editReport({{$report->id}})" 
                                            class="btn h-8 w-8 p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button @click="deleteItem" class="btn h-8 w-8 p-0 text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div
                class="flex flex-col justify-between space-y-4 px-4 py-4 sm:flex-row sm:items-center sm:space-y-0 sm:px-5"
            >
                <div class="flex items-center space-x-2 text-xs+">
                    <span>Show</span>
                    <label class="block">
                        <select
                            class="form-select rounded-full border border-slate-300 bg-white px-2 py-1 pr-6 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        >
                            <option>10</option>
                            <option>30</option>
                            <option>50</option>
                        </select>
                    </label>
                    <span>{{ __('entries') }}</span>
                </div>

                <ol class="pagination">
                    <li class="rounded-l-lg bg-slate-150 dark:bg-navy-500">
                        <a
                            href="#"
                            class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 19l-7-7 7-7"
                                />
                            </svg>
                        </a>
                    </li>
                    <li class="bg-slate-150 dark:bg-navy-500">
                        <a
                            href="#"
                            class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                            >1</a
                        >
                    </li>
                    <li class="bg-slate-150 dark:bg-navy-500">
                        <a
                            href="#"
                            class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg bg-primary px-3 leading-tight text-white transition-colors hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                        >
                            2
                        </a>
                    </li>
                    <li class="bg-slate-150 dark:bg-navy-500">
                        <a
                            href="#"
                            class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                        >
                            3
                        </a>
                    </li>
                    <li class="bg-slate-150 dark:bg-navy-500">
                        <a
                            href="#"
                            class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                        >
                            4
                        </a>
                    </li>
                    <li class="rounded-r-lg bg-slate-150 dark:bg-navy-500">
                        <a
                            href="#"
                            class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </a>
                    </li>
                </ol>
                <div class="text-xs+">1 - 10 {{ __('of') }} 10 {{ __('entries') }}</div>
            </div>
        </div>
    </div>
</div>