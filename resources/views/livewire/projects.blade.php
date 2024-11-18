<div>
    <main class="main-content todo-app">
        <livewire:project-modal />
           <!--header, title search, and filter block -->
        <div class="">
            
            <div class="flex justify-between space-x-2 px-2 py-2 transition-all duration-[.25s]">
                <!--  title -->
                <div>
                    <div class="flex space-x-2">
                        <p class="text-xl font-medium text-slate-800 dark:text-navy-50">
                            {{ __('Projects board') }}
                        </p>
                    </div>
                    <p class="mt-1 text-xs">List of your ongoing projects</p>
                </div>
                <!--  search bar -->
                <div class="flex items-center space-x-2">
                    <label class="relative hidden sm:flex">
                        <input wire:model = "searchTerm"
                            class="form-input peer h-9 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="Search projects..." type="text" />
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

                <!-- new project button -->

                <button wire:click="newProject()"
                    class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-50" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span> New Project</span>
                </button>
            </div>
        </div>

        <div class="mt-8 px-2 w-full grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 lg:gap-6 xl:grid-cols-4">
            @forelse($projects as $key=>$project)
                <div class="card shadow-none">
                    <div class="flex flex-1 flex-col rounded-lg bg-{{ $colors[$key] }}/15 p-4 dark:bg-transparent sm:p-5">
                        <div>
                            <div class="flex items-start justify-between">
                                <p class="text-xs+">
                                    @if($project->start_date)
                                        {{date('d-M-Y', strtotime($project->start_date))}}
                                    @endif
                                </p>
                                
                                <x-dropmenu name="test" :options="['Edit Project', 'Delete project', 'Manage project users']" 
                                record="{{$project->id}}"/>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('tasks', ['project_id' => $project->id]) }}">
                                <h2 class="mt-3 font-medium text-slate-700 line-clamp-2 dark:text-navy-100">
                                    {{$project->title}} 
                                </h2>
                                <p class="text-xs+">{{$project->description}}</p>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div>
                    <div colspan="6" class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-400">
                        {{ __('There are no records to display') }}
                    </div>
                </div>
            @endforelse
        </div>
        </main>
</div>
