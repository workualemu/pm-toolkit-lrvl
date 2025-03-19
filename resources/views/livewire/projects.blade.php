<div>
    <main class="main-content todo-app">
        <livewire:project-modal />
        <div class="px-4 py-2 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-medium text-blue-800 dark:text-navy-50">
                    {{ __('Projects Board') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('List of your projects') }}
                </p>
            </div>
            <div class="flex items-center space-x-2">
                <!-- Search Bar -->
                <label class="relative flex w-full sm:max-w-[16rem]">
                    <input
                        wire:model.live.debounce.500ms="searchTerm"
                        class="form-input peer h-8 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 text-xs+ placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Search projects..." type="text" />
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
            
            <x-button color="info" wire:click="newProject()">
                {{ __('Add new project') }}
            </x-button>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-4 mt-6">
            <div class="bg-white shadow-md rounded-xl p-6 border-t-4 border-gray-500">
                <h3 class="text-lg font-semibold text-gray-700">{{ __('Total Projects') }}</h3>
                <p class="mt-3 text-3xl font-bold text-gray-900">{{ $totalProjects }}</p>
            </div>
            <div class="bg-white shadow-md rounded-xl p-6 border-t-4 border-[#2D9CDB]">
                <h3 class="text-lg font-semibold text-[#2D9CDB]">{{ __('In Progress') }}</h3>
                <p class="mt-3 text-3xl font-bold text-[#2D9CDB]">{{ $inProgressProjects }}</p>
            </div>
            <div class="bg-white shadow-md rounded-xl p-6 border-t-4 border-[#F39C12]">
                <h3 class="text-lg font-semibold text-[#F39C12]">{{ __('On Hold') }}</h3>
                <p class="mt-3 text-3xl font-bold text-[#F39C12]">{{ $onHoldProjects }}</p>
            </div>
            <div class="bg-white shadow-md rounded-xl p-6 border-t-4 border-[#27AE60]">
                <h3 class="text-lg font-semibold text-[#27AE60]">{{ __('Completed') }}</h3>
                <p class="mt-3 text-3xl font-bold text-[#27AE60]">{{ $completedProjects }}</p>
            </div>
        </div>

        <!-- Project Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6 px-4 mt-6">
            @forelse($projects as $project)
                <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-4 py-3 flex justify-between items-center"
                        style="background-color: 
                        {{ $project->status === '1-in-progress' ? '#2D9CDB' : 
                           ($project->status === '2-on-hold' ? '#F39C12' : 
                           ($project->status === '3-completed' ? '#27AE60' : '#999')) }};">
                           <h3 class="text-sm font-semibold text-white">
                            {{ __($project->status === '1-in-progress' ? 'In Progress' : 
                                ($project->status === '2-on-hold' ? 'On Hold' : 'Completed')) }}
                            </h3>
                           
                        <x-dropmenu name="test" :options="['Edit Project', 'Delete project', 'Manage project users']"
                            record="{{ $project->id }}" />
                    </div>

                    <!-- Card Body -->
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-700">
                            {{ __($project->title) }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            {{ __($project->description) }}
                        </p>

                        <p class="mt-2 text-xs text-gray-600">
                            @if($project->start_date)
                                {{ date('d-M-Y', strtotime($project->start_date)) }}
                            @endif

                            @if($project->end_date)
                                to {{ date('d-M-Y', strtotime($project->end_date)) }}
                            @endif 
                        </p>

                        <div class="mt-4 flex justify-between items-center">
                            <a href="{{ route('tasks', ['project_id' => $project->id]) }}" 
                                class="text-blue-500 font-semibold hover:underline">
                                {{ __('View Tasks') }}
                            </a>
                            <div class="w-6/12 bg-gray-200 h-4 dark:bg-gray-700 overflow-hidden">
                                <x-progress-bar :progress="$project->progress" :status="$project->status" :end_date="$project->end_date" />
                            </div>
                            
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center px-6 py-4 text-sm text-gray-600">
                    {{ __('No projects found. Start by creating your first project!') }}
                    <a href="#" wire:click="newProject" class="text-blue-500 hover:underline">
                        {{ __('Create a Project') }}
                    </a>
                </div>
            @endforelse
        </div>
    </main>
</div>