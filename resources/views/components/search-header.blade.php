@props([
    'project_title' => '',
    'title' => 'Default Title',
    'subtitle' => '',
    'searchModel' => null
])

<div class="flex flex-col sm:flex-row sm:justify-between sm:space-x-2 px-2 py-2 transition-all duration-[.25s] space-y-2 sm:space-y-0">
    <div class="flex items-center px-2 justify-center sm:justify-start">
        <div>
            <div class="flex space-x-2">
                <p class="text-xl font-medium text-blue-800 dark:text-navy-50">
                {{ $project_title ?? '' }}
                </p>
                <p class="text-xl font-medium text-slate-800 dark:text-navy-50">
                |
                </p>
                <p class="text-xl font-medium text-slate-800 dark:text-navy-50">
                    {{ __($title) }}
                </p>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ __($subtitle) }}
            </p>
        </div>
    </div>


    <!-- Search Box (Responsive) -->
    <label class="relative flex w-full sm:max-w-[16rem]">
        <input 
            @if($searchModel) wire:model.live.debounce.500ms="{{ $searchModel }}" @endif
            class="form-input peer h-8 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 text-xs+ placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
            placeholder="{{ __('Search') }}" type="text" />
            
        <span
            class="pointer-events-none absolute flex h-full w-9 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-colors duration-200"
                fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z" />
            </svg>
        </span>
    </label>
</div>
