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
            <x-dialog-header title="{{ __('Project Template') }}" />
            <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto p-4">
                <x-input label="{{ __('Title') }}" name="title" model="title" placeholder="Enter title" />
                <div class="mt-4 space-y-4">
                    <label class="block">
                        <span>{{ __('Source project') }}</span>
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
                <x-textarea label="{{ __('Description') }}" name="description" model="description" placeholder="Enter description" />

                <x-date-picker label="{{ __('Start date') }}" id="start_date" model="start_date" defaultDate="{{ $start_date }}" datePickerDisabled="" />
            </div>
            <div class="py-4"></div>
            <div class="items-center border-t border-slate-150 py-3  dark:border-navy-600">
                <div class="px-2 flex items-center justify-between dark:border-navy-600">
                    <x-button color="error" @click="showModal=false">{{ __('Close') }}</x-button>
                    <x-button color="info" wire:click="store()">{{ __('Save') }}</x-button>
                </div>
            </div>
        </div>
    </div>
</div>