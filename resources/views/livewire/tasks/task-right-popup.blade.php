<div 
    x-data="{ 
            showModal: $wire.entangle('showTaskRightPopup'),
            refreshTaskComponent(taskId) {
                window.Livewire.dispatch('refreshTaskComponent.' + taskId);
            }
        }"
        x-init="$watch('showModal', value => { if (!value) { @this.call('closeModal'); } })"
        x-show="showModal" @click.away="showModal = true">
    
    <div class="flex flex-col items-center justify-center h-screen bg-slate-200"
            x-on:drop="isDroppingFile = false"
            x-on:drop.prevent="handleFileDrop($event)"
            x-on:dragover.prevent="isDroppingFile = true"
            x-on:dragleave.prevent="isDroppingFile = false"
        >
        
        <div x-show="showModal" @click.away="showModal = true">
            <!-- Background Overlay -->
            <div class="fixed inset-0 z-[100] bg-slate-900/60 transition-opacity duration-200" 
                @click="showModal = false"
                x-show="showModal"
                x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
            </div>

            <!-- Modal -->
            <div class="fixed right-0 top-0 z-[101] h-full w-full sm:w-4/6 lg:w-5/12">
                <div class="flex h-full w-full transform-gpu flex-col bg-white transition-transform duration-200 dark:bg-navy-700"
                    x-show="showModal" 
                    x-transition:enter="ease-out" x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="ease-in" x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full">
                    
                    <!-- Header -->
                    <x-dialog-header title="{{ $formTitle }}" />

                    <!-- Content -->
                    <div class="w-full h-full outline-none overflow-x-hidden overflow-y-auto grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                        
                        <!-- Main Content -->
                        <div class="col-span-12 md:col-span-6 lg:col-span-8">
                            <div class="is-scrollbar-hidden flex grow flex-col space-y-4 p-4">
                                <x-input label="{{ __('Title') }}" name="title" model="title" placeholder="Enter task title" required />
                                <x-textarea label="{{ __('Description') }}" name="description" model="description" placeholder="Enter description"/>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 w-full"> 
                                    <x-date-picker label="{{ __('Start date') }}" id="start_date" model="start_date" defaultDate="{{ $start_date }}" placeholder="Select start date" datePickerDisabled="{{ $datePickerDisabled }}" />
                                    <x-date-picker label="{{ __('Due date') }}" id="end_date" model="end_date" defaultDate="{{ $end_date }}" placeholder="Select due date" datePickerDisabled="{{ $datePickerDisabled }}" />
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 w-full">  
                                    <x-select label="{{ __('Assigned to') }}" model="assigned_to" :options="$users" valueField="id" nameField="name" selected="{{ $assigned_to }}" defaultText="{{ __('Select assignee') }}" />
                                    <x-select label="{{ __('Reported by') }}" model="report_by" :options="$users" valueField="id" nameField="name" selected="{{ $report_by }}" defaultText="{{ __('Select reporter') }}" />
                                </div>
                                <x-select label="{{ __('Tag') }}" model="taskTags" :options="$tags" valueField="id" nameField="label" defaultText="{{ __('Select tags') }}" multiple />
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 w-full"> 
                                    <x-select label="{{ __('Priority') }}" model="task_priority_id" :options="$taskPriorities" valueField="id" nameField="value" defaultText="{{ __('Select priority') }}" />
                                    <x-select label="{{ __('Status') }}" model="task_status_id" :options="$taskStatuses" valueField="id" nameField="value" defaultText="{{ __('Select status') }}" />
                                </div>
                                
                            </div>
                        </div>

                        <!-- Sidebar (Hidden on Small Screens) -->
                        <div class="col-span-12 sm:col-span-6 lg:col-span-4 border bg-slate-50">
                            <div class="col-span-12 sm:col-span-6 lg:col-span-8">
                                <div class="is-scrollbar-hidden flex grow flex-col space-y-4 p-4">
                                    <x-input label="{{ __('Progress(%)') }}" name="progress" model="progress" placeholder="Percent completed" />
                                    <div>
                                        <span>{{ __('Attachment') }}</span>
                                        @if($task != null)
                                            <livewire:tasks.task-file-upload :taskId="$task->id" />
                                        @else
                                            <p>Task not found!</p>
                                        @endif
                                    </div>

                                    @if($task->id > 0)
                                        <label class="block">
                                            <livewire:comments :model="$task"/>
                                        </label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="py-4"></div>
                    <div class="items-center border-t border-slate-150 py-3 dark:border-navy-600">
                        <div class="px-2 flex items-center justify-between dark:border-navy-600">
                            <x-button color="error" @click="showModal=false">{{ __('Delete') }}</x-button>
                            <x-button color="info" @click="showModal=false">{{ __('Close') }}</x-button>
                            <x-button color="info" wire:click="store()" @click="refreshTaskComponent({{ $task->id }})">{{ __('Save') }}</x-button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
