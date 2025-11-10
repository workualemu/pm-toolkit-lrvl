<div x-data="{ showModal: @entangle('showProjectModal') }">
    <div class="fixed inset-0 z-[100] flex items-center justify-center px-4 py-6 sm:px-5"
        x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
        
        <!-- Overlay -->
        <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
            @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
        </div>

        <!-- Modal Content -->
        <div class="relative bg-white dark:bg-navy-700 shadow-lg rounded-lg w-full max-w-3xl md:max-w-2xl lg:max-w-3xl"
            x-show="showModal" x-transition:enter="ease-out duration-300" 
            x-transition:enter-start="opacity-0 scale-90" 
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200" 
            x-transition:leave-start="opacity-100 scale-100" 
            x-transition:leave-end="opacity-0 scale-90">
            
            <!-- Modal Header -->
            <x-dialog-header title="{{ __('Project') }}" />

            <!-- Modal Body -->
            <div class="is-scrollbar-hidden flex flex-col space-y-4 overflow-y-auto p-6">
                <x-input 
                    label="{{ __('Title') }}" 
                    name="title" 
                    model="title" 
                    placeholder="Enter project title" 
                    required
                />
                <x-textarea 
                    label="{{ __('Description') }}" 
                    name="description" 
                    model="description" 
                    placeholder="Enter project description"
                />
                @if(!isset($project?->id))
                <x-select label="{{ __('Create from template') }}" 
                    model="selectedTemplate" 
                    :options="$templates" 
                    valueField="id" 
                    nameField="title" 
                    selected="{{ $selectedTemplate }}" 
                    defaultText="{{ __('Select template') }}" />
                @endif
                <x-date-picker label="{{ __('Start date') }}" 
                    id="start_date" 
                    model="start_date" 
                    defaultDate="{{ $start_date }}" 
                    placeholder="Select start date" 
                    datePickerDisabled="{{ $datePickerDisabled }}" />
                <x-select label="{{ __('Status') }}" 
                    model="status" 
                    :options="$statuses" 
                    valueField="id" 
                    nameField="name" 
                    selected="{{ $status }}" 
                    defaultText="{{ __('Select project status') }}" />
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-slate-200 dark:border-navy-600 flex justify-between">
                <x-button color="error" @click="showModal=false">
                    {{ __('Close') }}
                </x-button>
                @if(($user->hasRole('Super Admin') || $user->can(['create project', 'edit project'])) )
                <x-button color="info" wire:click="store()">
                    {{ __('Save') }}
                </x-button>
                @endif
            </div>
        </div>
    </div>
</div>
