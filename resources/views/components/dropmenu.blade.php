<div x-data="{ showModal: @entangle('showProjectModal'), showDeleteModal: @entangle('showDeleteModal') }">
    <div class="relative inline-block text-left"
        x-data="{
            open: false,
            toggle() {
                if (this.open) {
                    return this.close();
                }
                this.open = true;
            },
            close(focusAfter) {
                this.open = false;
                focusAfter && focusAfter.focus();
            },
            showEditProjectModal(project) {
                $wire.editProject(project);
            },
            showDeleteProjectModal(project) {
                $wire.showDeleteProjectModal(project.id);
            }
        }"
        x-on:keydown.escape.prevent.stop="close($refs.button)"
        x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
        x-id="['dropdown-button']">
        <div>
            <button x-ref="button"
                x-on:click="toggle()"
                :aria-expanded="open"
                :aria-controls="$id('dropdown-button')"
                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700" 
                id="menu-button" aria-expanded="true" aria-haspopup="true">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>
            </button>
        </div>
        <div x-ref="panel"
            x-show="open"
            x-transition.origin.top.right
            x-on:click.outside="close($refs.button)"
            :id="$id('dropdown-button')"
            style="display: none;"
            class="origin-top-right absolute right-0 mt-2 w-56 rounded-md"
            role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
            <div class="rounded-md border border-slate-150 bg-white py-1.5 dark:border-navy-500 dark:bg-navy-700">
                <ul>
                    <li>
                        <a x-on:click="showEditProjectModal({{$record}}); close($refs.button)"
                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                            @role('Project Manager')
                                Edit project
                            @else
                                View project details
                            @endrole
                        </a>
                    </li>
                    @role('Super Admin')
                    <li>
                        <a x-on:click="$wire.showDeleteProjectModal({{ $record }}); close($refs.button)"

                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                            Delete project
                        </a>    
                    </li>
                    @endrole
                </ul>
                @role('Project Manager')
                <div class="my-1 h-px bg-slate-150 dark:bg-navy-500"></div>
                <ul>
                    <li>
                        <a wire:click="manageProjectUsers({{$record}})"
                            x-on:click="close($refs.button)"
                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                            Manage project users</a>
                    </li>
                </ul>
                @endrole
                @role('Super Admin')
                <div class="my-1 h-px bg-slate-150 dark:bg-navy-500"></div>
                <ul>
                    <li>
                        <a wire:click="manageProjectUsers({{$record}})"
                            x-on:click="close($refs.button)"
                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                            Manage project users</a>
                    </li>
                </ul>
                @endrole
            </div>
        </div>
    </div>

    <div x-show="showModal" @keydown.window.escape="showModal = false" class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5" role="dialog">
        <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300" @click="showModal = false" x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
        <div class="relative flex flex-col overflow-hidden max-w-lg origin-top rounded-lg bg-white transition-all duration-300 dark:bg-navy-700" x-show="showModal" x-transition:enter="easy-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="easy-in" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" @keydown.window.escape="showDeleteModal = false" class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5" role="dialog">
        <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300" @click="showDeleteModal = false" x-show="showDeleteModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
        <div class="relative flex flex-col overflow-hidden max-w-lg origin-top rounded-lg bg-white transition-all duration-300 dark:bg-navy-700" x-show="showDeleteModal" x-transition:enter="easy-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="easy-in" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <div class="flex justify-between rounded-t-lg bg-slate-200 px-4 py-3 dark:bg-navy-800 sm:px-5">
                <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                    Delete Project
                </h3>
                <button @click="showDeleteModal = false" class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto px-4 py-4 sm:px-5">
                <div class="mt-4 space-y-4">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to delete this project?
                    </p>
                </div>
                <div class="mt-4 space-y-4">
                    <div class="flex justify-between space-x-2 text-right">
                        <button @click="showDeleteModal = false" class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            Cancel
                        </button>
     

<button wire:click="deleteProject"  class="btn min-w-[7rem] bg-red-500 font-medium text-white hover:bg-red-600 focus:bg-red-600 active:bg-red-600/90">
                            Delete
                        </button>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>