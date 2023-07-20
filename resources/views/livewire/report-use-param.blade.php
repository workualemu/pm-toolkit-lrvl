<div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
    <div>
        <div class="flex items-center justify-between">
            <div>
                <button wire:click="addNewReportParam()"
                    class="border-b border-dotted border-current pb-0.5 font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70"
                >
                    Add new parameter
                </button>
            </div>
        </div>

        <div class="card mt-3">
            <div
                class="is-scrollbar-hidden min-w-full overflow-x-auto"
                x-data="pages.tables.initExample1"
            >
                

                <div class="mt-3 grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                    <div class="col-span-12 sm:col-span-6 lg:col-span-8">
                        <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto p-4">
                            @foreach($params as $param)
                                <label class="block">
                                    <span>{{$param->title}}</span>
                                    @if($param->type == 'select')
                                        <select wire:model.defer="param_res.{{$param->db_column}}"
                                            class="form-select rounded-full border border-slate-300 bg-white px-2 py-1 pr-6 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                        >
                                            @foreach($param->options as $option)
                                                <option>{{ $option->{$param->db_column} }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input wire:model.defer="param_res.{{$param->db_column}}"
                                            class="form-input mt-1.5 h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Enter parameter title" type="text" />
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div
                    class="flex items-center justify-between border-t border-slate-150 py-3 px-4 dark:border-navy-600">
                    <div class="flex space-x-1">
                    </div>
                    <button wire:click="generateReport()"
                        class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        Generate report
                    </button>
                </div>
            </div>
        </div>
    </div>
    
</div>