<div x-data="{ open: false, showDeleteModal: false, projectToDelete: null }">
    <div class="relative inline-block text-left"
        x-data="{
            open: false,
            toggle() {
                if (this.open) {
                    return this.close()
                }
                this.open = true
            },
            close(focusAfter) {
                this.open = false
                focusAfter && focusAfter.focus()
            },
            showEditProjectModal(project) {
                $wire.editProject(project);
            },
            showDeleteProjectModal(project) {
                this.projectToDelete = project;
                this.showDeleteModal = true;
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
            <div
                class="rounded-md border border-slate-150 bg-white py-1.5 dark:border-navy-500 dark:bg-navy-700">
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
                        <a x-on:click="showDeleteProjectModal({{$record}}); close($refs.button)"
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
                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                            Manage project users</a>
                    </li>
                </ul>
                @endrole
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
        <div class="bg-white p-5 border w-96 shadow-lg rounded-md">
            <div class="text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Delete Project
                </h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to delete this project?
                    </p>
                </div>
                <div class="flex justify-evenly px-4 py-3">
                    <button x-on:click="showDeleteModal = false" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600">
                        Cancel
                    </button>
                    <button x-on:click="$wire.deleteProject(projectToDelete); showDeleteModal = false" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-600">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>