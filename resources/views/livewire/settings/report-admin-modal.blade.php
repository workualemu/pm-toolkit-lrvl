<div x-data="{ showReportModal: @entangle('showReportModal') }">
    <div class="flex flex-col items-center justify-center h-screen bg-slate-200"
            x-on:drop="isDroppingFile = false"
            x-on:drop.prevent="handleFileDrop($event)"
            x-on:dragover.prevent="isDroppingFile = true"
            x-on:dragleave.prevent="isDroppingFile = false"
        >
        <div x-show="showReportModal" @click.away="showReportModal = false">
            <div class="fixed inset-0 z-[100] bg-slate-900/60 transition-opacity duration-200" @click="showReportModal = false"
                x-show="showReportModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"> 
            </div>
            <div class="fixed right-0 top-0 z-[101] h-full w-5/12">
                <div class="flex h-full w-full transform-gpu flex-col bg-white transition-transform duration-200 dark:bg-navy-700"
                    x-show="showReportModal" x-transition:enter="ease-out" x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0" x-transition:leave="ease-in"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                    <div class="flex h-14 items-center justify-between bg-slate-150 p-4 dark:bg-navy-800">
                        <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                            {{ __('Report') }}
                        </h3>
                        <div class="-mr-1.5 flex items-center space-x-2.5">
                            <input x-tooltip.primary="'Mark as Completed'"
                                x-effect="showReportModal && setTimeout(() => showReportModal && $el.__x_tippy.show(), 500)"
                                class="form-checkbox is-basic h-5 w-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                type="checkbox" />
                            <div class="flex">
                                <button x-data="{ isImportant: false }" @click.stop="isImportant =! isImportant"
                                    class="btn h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <svg x-show="!isImportant" xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    <svg x-show="isImportant" xmlns="http://www.w3.org/2000/svg"
                                        class="h-5.5 w-5.5 text-primary dark:text-accent" viewBox="0 0 20 20"
                                        fill="currentColor" style="display: none">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </button>
                                <button @click="showReportModal=false"
                                    class="btn h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 h-full overflow-y-scroll">
                        <div class="col-span-12 sm:col-span-6 lg:col-span-8">
                            <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto p-4">
                                <label class="block">
                                    <span>{{ __('Report title') }}</span>
                                    <input id="title" wire:model.defer="title"
                                        class="form-input mt-1.5 h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Enter report title" type="text" />
                                </label>
                                <label class="block">
                                    <span>{{ __('Description') }}</span>
                                    <input id="description" wire:model.defer="description"
                                        class="form-input mt-1.5 h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Enter report rescription" type="text" />
                                </label>
                                <label class="block">
                                    <span>{{ __('Select clause') }}</span>
                                    <textarea rows="2" wire:model.defer="select_clause"
                                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        name="select_clause"
                                        placeholder="Enter select clause"
                                        id="select_clause">
                                    </textarea>
                                </label>
                                <label class="block">
                                    <span>{{ __('From clause') }}</span>
                                    <textarea rows="2" wire:model.defer="from_clause"
                                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        name="from_clause"
                                        placeholder="Enter from clause"
                                        id="from_clause">
                                    </textarea>
                                </label>
                                <label class="block">
                                    <span>{{ __('Where clause') }}</span>
                                    <textarea rows="2" wire:model.defer="where_clause"
                                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        name="where_clause"
                                        placeholder="Enter where clause"
                                        id="where_clause">
                                    </textarea>
                                </label>
                                
                                <label class="block">
                                    <span>{{ __('Group by clause') }}</span>
                                    <textarea rows="2" wire:model="groupby_clause"
                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        name="groupby_clause"
                                        placeholder="Enter group by clause"
                                        id="groupby_clause">
                                    </textarea>
                                </label>
                                <label class="block">
                                    <span>{{ __('Having clause') }}</span>
                                    <textarea rows="2" wire:model="having_clause"
                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        name="having_clause"
                                        placeholder="Enter having clause"
                                        id="having_clause">
                                    </textarea>
                                </label>
                                <label class="block">
                                    <span>{{ __('Order by clause') }}</span>
                                    <textarea rows="2" wire:model="order_clause"
                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        name="order_clause"
                                        placeholder="Enter order by clause"
                                        id="order_clause">
                                    </textarea>
                                </label>
                                <label class="inline-flex items-center space-x-2">
                                    <input wire:model.defer="published"
                                        class="form-switch h-5 w-10 rounded-lg bg-slate-300 before:rounded-md before:bg-slate-50 checked:!bg-info checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:before:bg-white"
                                        type="checkbox"
                                    />
                                    <span>{{ __('Published') }}</span>
                                </label>
                                <label class="inline-flex items-center space-x-2">
                                    <input wire:model.defer="show_meta"
                                        class="form-switch h-5 w-10 rounded-lg bg-slate-300 before:rounded-md before:bg-slate-50 checked:!bg-info checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:before:bg-white"
                                        type="checkbox"
                                    />
                                    <span>{{ __('Show meta') }}</span>
                                </label>
                                <label class="inline-flex items-center space-x-2">
                                    <input wire:model.defer="show_print_date"
                                        class="form-switch h-5 w-10 rounded-lg bg-slate-300 before:rounded-md before:bg-slate-50 checked:!bg-info checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:before:bg-white"
                                        type="checkbox"
                                    />
                                    <span>{{ __('Show print date') }}</span>
                                </label>
                                <label class="inline-flex items-center space-x-2">
                                    <input wire:model.defer="show_print_user"
                                        class="form-switch h-5 w-10 rounded-lg bg-slate-300 before:rounded-md before:bg-slate-50 checked:!bg-info checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:before:bg-white"
                                        type="checkbox"
                                    />
                                    <span>{{ __('Show user') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-between border-t border-slate-150 py-3 px-4 dark:border-navy-600">
                        <div class="flex space-x-1">
                            <button
                                class="btn h-8 w-8 rounded-full p-0 text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        <button wire:click="store()"
                            class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            {{ __('Save') }}
                        </button>
                        <button @click="showReportModal=false"
                            class="btn min-w-[7rem] bg-error font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            {{ __('Close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
