<div x-data="{showModal: @entangle('showModal')}">
    <div class="flex flex-col items-center justify-center h-screen bg-slate-200"
        x-on:drop="isDroppingFile = false"
        x-on:drop.prevent="handleFileDrop($event)"
        x-on:dragover.prevent="isDroppingFile = true"
        x-on:dragleave.prevent="isDroppingFile = false"
    >
        <!-- Modal -->
        <div x-show="showModal" @click.away="showModal = false">
            <!-- Overlay -->
            <div class="fixed inset-0 z-[100] bg-slate-900/60 transition-opacity duration-200" 
                @click="showModal = false"
                x-show="showModal" 
                x-transition:enter="ease-out" 
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" 
                x-transition:leave="ease-in" 
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
            </div>

            <!-- Modal Content -->
            <div class="fixed z-[101] h-full left-1/3 top-2">
                <div class="flex w-full flex-col bg-white dark:bg-navy-700">
                    <!-- Modal Header -->
                    <x-dialog-header title="{{ __('Tag') }}" />

                    <!-- Modal Body -->
                    <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto p-4">
                        <x-input 
                            label="{{ __('Label') }}" 
                            name="label" 
                            model="label" 
                            placeholder="Enter label" 
                        />
                        <x-textarea 
                            label="{{ __('Description') }}" 
                            name="description" 
                            model="description" 
                            placeholder="Enter description" 
                        />
                        <x-color-picker 
                            name="color" 
                            model="color" 
                        />
                    </div>

                    <div class="py-4"></div>

                    <!-- Modal Footer -->
                    <div class="items-center border-t border-slate-150 py-3 dark:border-navy-600">
                        <div class="px-2 flex items-center justify-between dark:border-navy-600">
                            <x-button color="error" @click="showModal=false">
                                {{ __('Close') }}
                            </x-button>
                            <x-button color="info" wire:click="store()">
                                {{ __('Save') }}
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
