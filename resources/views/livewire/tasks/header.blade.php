<div class="" x-data="{ isFilterExpanded: false }"
    x-effect="$store.breakpoints.smAndUp ">
    <!-- My task and search bar -->
    <x-task-search :project_title="$project_title" :page_title="$page_title"></x-task-search>
    <!-- Filter block -->
    <div x-show="isFilterExpanded" x-collapse>
    <div class="max-w-xl py-3">
        <div class="grid px-2 grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:gap-6">
        <label class="block">
            <span>{{__('Title')}}:</span>
            <div class="relative mt-1.5 flex">
            <input wire:model="fTitle"
                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                placeholder="{{__('Enter task title')}}"
                type="text"
            />
            <span
                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent"
            >
                <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4.5 w-4.5 transition-colors duration-200"
                fill="none"
                viewBox="0 0 24 24"
                >
                <path
                    stroke="currentColor"
                    stroke-width="1.5"
                    d="M5 19.111c0-2.413 1.697-4.468 4.004-4.848l.208-.035a17.134 17.134 0 015.576 0l.208.035c2.307.38 4.004 2.435 4.004 4.848C19 20.154 18.181 21 17.172 21H6.828C5.818 21 5 20.154 5 19.111zM16.083 6.938c0 2.174-1.828 3.937-4.083 3.937S7.917 9.112 7.917 6.937C7.917 4.764 9.745 3 12 3s4.083 1.763 4.083 3.938z"
                />
                </svg>
            </span>
            </div>
        </label>
        <label class="block">
            <span>Phase:</span>
            <div class="relative mt-1.5 flex">
            <select wire:model="fPhase"
                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
            >
                <option value="0">{{__('Select project phase') }}</option>
                @foreach($phases as $phase)
                <option value="{{$phase->id}}">{{$phase->title}}</option>
                @endforeach
            </select>
            </div>
        </label>
        <label class="block">
            <span>{{__('From')}}:</span>
            <div class="relative mt-1.5 flex">
            <input wire:model="fDateFrom"
                x-init="$el._x_flatpickr = flatpickr($el)"
                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                placeholder="{{ __('Choose start date') }}..."
                type="text"
                />
            <span
                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent"
            >
                <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 transition-colors duration-200"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.5"
                >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                />
                </svg>
            </span>
            </div>
        </label>
        <label class="block">
            <span>{{ __('To') }}:</span>
            <div class="relative mt-1.5 flex">
            <input wire:model="fDateTo"
            x-init="$el._x_flatpickr = flatpickr($el)"
                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                placeholder="{{ __('Choose end date') }}..."
                type="text"
            />
            <div class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 transition-colors duration-200"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.5"
                >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                />
                </svg>
            </div>
            </div>
        </label>
        @if($showStatusFilter)
            <div class="sm:col-span-2">
                <span>Task Status:</span>
                <div class="mt-2 grid grid-cols-1 gap-4 sm:grid-cols-4 sm:gap-5 lg:gap-6">
                    @foreach($statuses as $key => $status)
                        <label class="inline-flex items-center space-x-2">
                        <input wire:model="selectedStatuses.{{$status->id}}"
                            class="form-checkbox bg-{{$status->color}}-500 is-basic h-5 w-5 rounded border-{{$status->color}}-200 checked:border-{{$status->color}}-900 checked:{{$status->color}} hover:border-{{$status->color}}-900 focus:border-{{$status->color}}-900 dark:border-navy-400 dark:checked:border-secondary-light dark:checked:bg-secondary-light dark:hover:border-secondary-light dark:focus:border-secondary-light"
                            type="checkbox"
                        />
                        <span>{{$status->value}}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endif
        </div>
        <div class="mt-4 space-x-1 text-right">
        <button
            @click="isFilterExpanded = ! isFilterExpanded"
            class="btn font-medium text-slate-700 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25">
            {{ __('Cancel') }}
        </button>
        <button
            wire:click="applyFilter()"
            @click="isFilterExpanded = ! isFilterExpanded"
            class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            {{ __('Apply') }}
        </button>
        </div>
    </div>
    </div>
</div>