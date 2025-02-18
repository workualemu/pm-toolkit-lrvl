<div x-data="{ showModal: @entangle('showModal') }">
    <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
        x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
        <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
            @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
        </div>
        <div class="relative flex flex-col overflow-hidden max-w-lg origin-top rounded-lg bg-white transition-all duration-300 dark:bg-navy-700"
            x-show="showModal" x-transition:enter="easy-out"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="easy-in"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95">
            <div
                class="flex justify-between rounded-t-lg bg-slate-200 px-4 py-3 dark:bg-navy-800 sm:px-5">
                <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                    {{ __('Project Template') }}
                </h3>
                <button @click="showModal = !showModal"
                    class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto px-4 py-4 sm:px-5">
                <div class="mt-4 space-y-4">
                    <label class="block">
                        <span>{{ __('Title') }}:</span>
                        <input {{$readOnly}} type="text" wire:model.lazy='title'
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="Enter title"/>
                    </label>
                </div>
                <div class="mt-4 space-y-4">
                    <div class="mt-4 space-y-4">
                        <label class="block">
                            <span>{{ __('Source project') }}:</span>
                            <select {{$readOnly}} x-init="$el._x_tom = new Tom($el)" 
                                class="mt-1.5 w-full" 
                                placeholder="Select project status"
                                wire:model="sourceProject" 
                                autocomplete="off">
                                <option value="0">{{ __('Select source project') }}</option>
                                @foreach($projects as $project)
                                    <option value="{{$project->id}}">{{$project->title}}</option>
                                @endforeach
                            </select>
                        </label>
                        @error('sourceProject')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mt-4 space-y-4">
                    <label class="block">
                        <span>{{ __('Description') }}:</span>
                        <textarea {{$readOnly}} wire:model.lazy='description' 
                            rows="4" placeholder="Enter description"
                            class="form-textarea mt-1.5 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"></textarea>
                    </label>
                </div>

                <div class="mt-4 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <label class="block">
                            <span>{{ __('Start date') }}:</span>
                            <input {{$readOnly}}  wire:model.lazy='start_date' 
                                type="date"
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="Select start date"/>
                        </label>
                        <label class="block">
                            <span>{{ __('End date') }}:</span>
                            <input {{$readOnly}}  wire:model.lazy='end_date' 
                                type="date" 
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="Select end date"/>
                        </label>
                    </div>
                </div>

                <div class="mt-4 space-y-4">
                    <div class="mt-4 space-y-4">
                        <label class="block">
                            <span>{{ __('Status') }}:</span>
                            <select {{$readOnly}} x-init="$el._x_tom = new Tom($el)" class="mt-1.5 w-full" placeholder="Select project status"
                                wire:model.lazy="status" 
                                autocomplete="off">
                                <option value="ACTIVE">{{ __('Active') }}</option>
                                <option value="SUSPENDED">{{ __('Suspended') }}</option>
                                <option value="CLOSED">{{ __('Closed') }}</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="mt-4 space-y-4">
                    <div class="flex justify-between space-x-2 text-right">
                        <button @click="showModal = false"
                            class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            <a href="{{ route('template-projects') }}">
                                {{ __('Cancel') }}
                            </a>
                        </button>
                        <button  wire:click="store()"
                            class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>