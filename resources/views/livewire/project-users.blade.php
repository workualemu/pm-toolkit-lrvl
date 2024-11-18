<main class="main-content kanban-app w-full">
    @if($project == null)
        <div class="text-center text-error">
            <div class="mt-4">
                <p class="text-error dark:text-navy-300">
                    Please select a project
                </p>
            </div>
        </div>
    @else
        <p class="mt-1 text-xs text-info">
            <span>{{ $project->title }}</span>
        </p>

        <!--header, title search, and filter block -->
        <div class="" >
            <!-- My task and search bar -->
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex space-x-2">
                        <p class="text-xl font-medium text-slate-800 dark:text-navy-50">
                            Project users
                        </p>
                    </div>
                    <p class="mt-1 text-xs">{{ __('Manage users assignment to this project') }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <label class="relative hidden sm:flex">
                        <input wire:model = "searchTerm"
                            class="form-input peer h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="Search users..." type="text" />
                        <span
                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 transition-colors duration-200"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z" />
                            </svg>
                        </span>
                    </label>
                </div>
            </div>

            <!-- Filter block -->
            <div >
                <div class="max-w-xl py-3">
                    <div class="grid grid-cols-4 gap-4 sm:grid-cols-2 sm:gap-5 lg:gap-6">
                        <div class="sm:col-span-2">
                            <div class="mt-2 grid grid-cols-1 gap-4 sm:grid-cols-4 sm:gap-5 lg:gap-6">
                                @foreach($users as $user)
                                    <label class="inline-flex items-center space-x-2">
                                        <input wire:model="projectUsers.{{$user->id}}"
                                            class="form-switch h-5 w-10 rounded-full bg-slate-300 before:rounded-full before:bg-slate-50 checked:!bg-info checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:before:bg-white"
                                            type="checkbox"
                                        />
                                        <p>{{$user->name}}</p>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 space-x-1 text-right">
                        <button
                            class="btn font-medium text-slate-700 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <a href="{{ route('index') }}">{{ __('Cancel') }}</a>
                        </button>
                        <button
                            wire:click="assignUsers()"
                            class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</main>
