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

        <div class="w-full mt-4">
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
        </div>
    </div>
</div>