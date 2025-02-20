<div x-data="{ showModal: @entangle('showModal') }">
    <div class="flex flex-col items-center justify-center h-screen bg-slate-200"
        x-on:drop="isDroppingFile = false"
        x-on:drop.prevent="handleFileDrop($event)"
        x-on:dragover.prevent="isDroppingFile = true"
        x-on:dragleave.prevent="isDroppingFile = false"
    >
        <!-- Modal Overlay -->
        <div x-show="showModal" @click.away="showModal = false">
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

            <!-- Slide-in Panel (Right) -->
            <div class="fixed right-0 top-0 z-[101] h-full w-5/12">
                <div class="flex h-full w-full transform-gpu flex-col bg-white transition-transform duration-200 dark:bg-navy-700"
                    x-show="showModal" 
                    x-transition:enter="ease-out" 
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0" 
                    x-transition:leave="ease-in"
                    x-transition:leave-start="translate-x-0" 
                    x-transition:leave-end="translate-x-full"
                >
                    <!-- Modal Content -->
                    <div class="flex flex-col h-full">
                            <x-dialog-header title="{{ __('Report') }}" />


                        <!-- Scrollable Middle Section -->
                        <div class="flex-grow overflow-y-auto p-4 space-y-4 is-scrollbar-hidden">
                            <x-input label="{{ __('Title') }}" name="title" model="title" placeholder="Enter report title" />
                            <x-textarea label="{{ __('Description') }}" name="description" model="description" placeholder="Enter description" />
                            <x-textarea label="{{ __('Select clause') }}" name="select_clause" model="select_clause" placeholder="Enter select clause" />
                            <x-textarea label="{{ __('From clause') }}" name="from_clause" model="from_clause" placeholder="Enter from clause" />
                            <x-textarea label="{{ __('Where clause') }}" name="where_clause" model="where_clause" placeholder="Enter where clause" />
                            <x-textarea label="{{ __('Group clause') }}" name="groupby_clause" model="group_clause" placeholder="Enter group clause" />
                            <x-textarea label="{{ __('Having clause') }}" name="having_clause" model="having_clause" placeholder="Enter having clause" />
                            <x-textarea label="{{ __('Order clause') }}" name="order_clause" model="order_clause" placeholder="Enter order clause" />
                            <x-check-box label="{{ __('Published') }}" id="published" model="published"/>
                            <x-check-box label="{{ __('Show meta') }}" id="show_meta" model="show_meta"/>
                        </div>

                        <!-- Footer (Fixed at Bottom) -->
                        <div class="p-4 border-t border-slate-150 dark:border-navy-600 bg-white dark:bg-navy-700">
                            <div class="flex items-center justify-between">
                                <x-button color="error" @click="showModal=false">{{ __('Close') }}</x-button>
                                <x-button color="info" wire:click="store()">{{ __('Save') }}</x-button>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Content -->
                </div>
            </div>
        </div>
    </div>
</div>
