<div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
    <div>
        <div class="flex items-center justify-between">
            <h2>
                 Parameters
            </h2>
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
                                @if($param->type == 'Date')
                                    <div>
                                        <span>{{$param->title}}:</span>
                                        <label class="relative mt-1.5 flex">
                                            <input wire:model.defer="param_res.{{$param->db_column}}" x-init="$el._x_flatpickr = flatpickr($el, { defaultDate: '2020-01-05' })"
                                                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                placeholder="Choose date..." type="text" />
                                            <span
                                                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </span>
                                        </label>
                                    </div>
                                @endif
                                @if($param->type == 'select')
                                    <div>
                                        <span>{{$param->title}}:</span>
                                        <select wire:model.defer="param_res.{{$param->db_column}}"
                                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                        >
                                            @foreach($param->options as $option)
                                                <option>{{ $option->{$param->db_column} }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                @if($param->type == 'Text')
                                    <div>
                                        <span>{{$param->title}}:</span>
                                        <input wire:model.defer="param_res.{{$param->db_column}}"
                                            class="form-input mt-1.5 h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Enter parameter value" type="text" />
                                    </div>
                                @endif
                                @if($param->type == 'Contain')
                                    <div>
                                        <span>{{$param->title}}:</span>
                                        <input wire:model.defer="param_res.{{$param->db_column}}"
                                            class="form-input mt-1.5 h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Enter parameter values separated by comma" type="text" />
                                    </div>
                                @endif
                                @if($param->type == 'Range')
                                    <div class="">
                                        <span>{{$param->title}}:</span>
                                        <label class="relative mt-1.5 flex w-full">
                                                <span>From:</span>
                                                <input wire:model.defer="param_res.{{$param->db_column}}.from"
                                                    class="form-input mt-1.5 h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="Enter parameter value" type="text" />
                                                <span>To:</span>
                                                <input wire:model.defer="param_res.{{$param->db_column}}.to"
                                                    class="form-input mt-1.5 h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="Enter parameter value" type="text" />
                                        </label>
                                    </div>
                                @endif
                                @if($param->type == 'Date range')
                                    <div class="">
                                        <span>{{$param->title}}:</span>
                                        <label class="relative mt-1.5 flex">
                                            <label class="relative mt-1.5 flex w-full">
                                                <span>From:</span>
                                                <input wire:model.defer="param_res.{{$param->db_column}}.from" x-init="$el._x_flatpickr = flatpickr($el, { defaultDate: '2020-01-05' })"
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="Choose date..." type="text" />
                                                <span
                                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                            </label>
                                            <label class="relative mt-1.5 flex w-full">
                                            <span>To:</span>
                                                <input wire:model.defer="param_res.{{$param->db_column}}.to" x-init="$el._x_flatpickr = flatpickr($el, { defaultDate: '2020-01-05' })"
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="Choose date..." type="text" />
                                                <span
                                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                            </label>
                                                    
                                        </label>
                                    </div>
                                @endif
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