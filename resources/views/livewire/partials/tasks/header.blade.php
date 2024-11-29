<div class="" x-data="{ isFilterExpanded: false }"
    x-effect="$store.breakpoints.smAndUp ">
    <!-- My task and search bar -->
    <div class="flex justify-between space-x-2 px-2 py-2 transition-all duration-[.25s]">
    <div class="flex items-center space-x-1">
        <h3 class="text-lg font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
        {{ __('My tasks') }} 
        </h3>
    </div>
    <div class="relative hidden w-full max-w-[16rem] sm:flex">
        <label class="relative hidden w-full max-w-[16rem] sm:flex">
        <input wire:model.live = "searchTerm"
            class="form-input peer h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
            placeholder="Search tasks..." type="text" />
        <span
            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 transition-colors duration-200"
            fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z" />
            </svg>
        </span>
        </label>
        <div class="flex">
        <button @click="isSearchbarActive = true" x-tooltip="'Search'"
            class="btn h-9 w-9 p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button>
        <button x-tooltip="'Filter'"
            @click="isFilterExpanded = !isFilterExpanded"
            class="btn h-9 w-9 p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
        </button>
        </div>
    </div>
    <div class="relative hidden w-full max-w-[12rem] sm:flex">
            <button
                class="btn h-6 w-6 rounded-full p-0 font-medium text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25 sm:h-8 sm:w-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path
                        d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                </svg>
            </button>
        </div>
    </div>

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