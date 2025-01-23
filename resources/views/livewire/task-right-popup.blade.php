<div x-data="{ showModal: @entangle('showModal') }">
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
            <div class="fixed right-0 top-0 z-[101] h-full w-5/12">
                <div class="flex h-full w-full transform-gpu flex-col bg-white transition-transform duration-200 dark:bg-navy-700"
                    x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0" x-transition:leave="ease-in"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                    <div class="flex h-14 items-center justify-between bg-slate-150 p-4 dark:bg-navy-800">
                        <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                            {{ $formTitle }}
                        </h3>
                        <div class="-mr-1.5 flex items-center space-x-2.5">
                            <div class="flex">
                                <button @click="showModal=false"
                                    class="btn h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @if($project == null)
                    <div class="text-center text-error">
                        <div class="mt-4">
                            <p class="text-error dark:text-navy-300">
                                Please select a project
                            </p>
                        </div>
                    </div>
                    @else
                    <div class="w-full h-full outline-none overflow-x-hidden overflow-y-auto mt-3 grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                        <div class="col-span-12 sm:col-span-6 lg:col-span-8">
                            <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto p-4">
                                <label class="block">
                                    <span>{{ __('Task title') }}</span>
                                    <input id="title" wire:model.defer="task.title"
                                        class="form-input mt-1.5 h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Enter task name" type="text" />
                                </label>
                                <div>
                                    <span>{{ __('Start date') }}:</span>
                                    <label class="relative mt-1.5 flex">
                                        <input id="start_date" wire:model.defer="task.start_date" x-init="$el._x_flatpickr = flatpickr($el, { enableTime: false, time_24hr: false, dateFormat: 'd-M-Y' })"
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Choose start date..." type="text" />
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
                                <div>
                                    <span>{{ __('Due date') }}:</span>
                                    <label class="relative mt-1.5 flex">
                                        <input id="end_date" wire:model.defer="task.end_date" x-init="$el._x_flatpickr = flatpickr($el, { enableTime: false, time_24hr: false, dateFormat: 'd-M-Y' })"
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Choose due date..." type="text" />
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
                                <label class="block">
                                    <span>{{ __('Assigned to') }}:</span>
                                    <select x-init="$el._x_tom = new Tom($el)" class="mt-1.5 w-full" placeholder="Select user"
                                        wire:model.defer="task.assigned_to" 
                                        autocomplete="off">
                                        <option value="0">{{ __('Select assignee') }}</option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </label>
                                <label class="block">
                                    <span>{{ __('Reported by') }}:</span>
                                    <select x-init="$el._x_tom = new Tom($el)" class="mt-1.5 w-full" placeholder="Select user"
                                        wire:model.defer="task.report_by" 
                                        autocomplete="off">
                                        <option value="0">{{ __('Select reporter') }}</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </label>

                                <label class="block">
                                    <span>{{ __('Description') }}</span>
                                    <textarea rows="3" wire:model.defer="task.description"
                                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        name="description"
                                        id="description">
                                    </textarea>
                                </label>
                                <div>
                                    <span>{{ __('Attachment') }}</span>
                                    @if($task != null)
                                        <livewire:task-file-upload :taskId="$task->id" />
                                    @else
                                        <p>Task not found!</p>
                                    @endif
                                </div>
                                @if($task->id > 0)
                                    <label class="block">
                                        @livewire('comments', ['model' => $task])
                                    </label>
                                @endif
                            </div>
                        </div>
                        <div class="hidden sm:col-span-6 sm:block lg:col-span-4 border bg-slate-50">
                            <div class="col-span-12 sm:col-span-6 lg:col-span-8">
                                <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto p-4">
                                    <label class="block">
                                        <span>{{ __('Tag') }}:</span>
                                        <select x-init="$el._x_tom = new Tom($el)" class="mt-1.5 w-full" multiple placeholder="Select the tags"
                                            wire:model.defer="taskTags" 
                                            autocomplete="off">
                                            @foreach($tags as $tag)
                                                <option value="{{$tag->id}}">{{$tag->label}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label class="block">
                                        <span>Priority:</span>
                                        <select class="mt-1.5 w-full" placeholder="Select priority"
                                            wire:model.defer="task.task_priority_id" 
                                            autocomplete="off">
                                            <option value="">Select priority</option>
                                            @foreach($taskPriorities as $taskPriority)
                                            <option value="{{$taskPriority->id}}">{{$taskPriority->value}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label class="block">
                                        <span>{{ __('Status') }}:</span>
                                        <select class="mt-1.5 w-full" placeholder="Select status"
                                            wire:model.defer="task.task_status_id" 
                                            autocomplete="off">
                                            <option value="">Select status</option>
                                            @foreach($taskStatuses as $taskStatus)
                                            <option value="{{$taskStatus->id}}">{{$taskStatus->value}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div
                        class="flex items-center justify-between border-t border-slate-150 py-3 px-4 dark:border-navy-600">
                        @if($project != null)
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
                        @endif
                        <button @click="showModal=false"
                            class="btn min-w-[7rem] bg-error font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            {{ __('Close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
