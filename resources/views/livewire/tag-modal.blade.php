@props(['hexadecimal' => false])
<div x-data="{ showModal: @entangle('showModal')}">
    <div class="flex flex-col items-center justify-center h-screen bg-slate-200"
            x-on:drop="isDroppingFile = false"
            x-on:drop.prevent="handleFileDrop($event)"
            x-on:dragover.prevent="isDroppingFile = true"
            x-on:dragleave.prevent="isDroppingFile = false"
        >
        <div x-show="showModal" @click.away="showModal = false">
            <div class="fixed inset-0 z-[100] bg-slate-900/60 transition-opacity duration-200" @click="showModal = false"
                x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"> 
            </div>
            <div class="fixed  z-[101] h-full left-1/3 top-2">
                <div class="flex w-full flex-col bg-white dark:bg-navy-700">
                    <div class="flex h-14 items-center justify-between bg-slate-150 p-4 dark:bg-navy-800">
                        <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                            Tag
                        </h3>
                    </div>

                    <div class="mt-3 grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                        <div class="col-span-12 sm:col-span-6 lg:col-span-8">
                            <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto p-4">
                                <label class="block">
                                    <span>Tag</span>
                                    <input id="title" wire:model.defer="tag.label"
                                        class="form-input mt-1.5 h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Enter report title" type="text" />
                                </label>
                                <label class="block">
                                    <span>Description</span>
                                    <input id="description" wire:model.defer="tag.description"
                                        class="form-input mt-1.5 h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Enter report rescription" type="text" />
                                </label>

                                <label class="block">
                                    <span>Color</span>
                                    <x-color-picker
                                        placeholder="Select color"
                                        wire:model.defer="tag.color"
                                        :colors="[
                                            [ 'name' => 'Primary',   'value' => '#3490dc' ],
                                            [ 'name' => 'Teal',   'value' => '#14b8a6' ],
                                            [ 'name' => 'Slate',  'value' => '#64748b' ],
                                            [ 'name' => 'Red',    'value' => '#ef4444' ],
                                            [ 'name' => 'Lime',   'value' => '#a3e635' ],
                                            [ 'name' => 'Sky',    'value' => '#38bdf8' ],
                                            [ 'name' => 'Violet', 'value' => '#8b5cf6' ],
                                            [ 'name' => 'Secondary',   'value' => '#ffed4a' ],
                                            [ 'name' => 'Indigo', 'value' => '#6366f1' ],
                                            [ 'name' => 'Danger', 'value' => '#e3342f' ],
                                        ]"
                                    />
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
                            Save
                        </button>
                        <button @click="showModal=false"
                            class="btn min-w-[7rem] bg-error font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
