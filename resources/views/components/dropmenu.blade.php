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
                @role(['Project Manager', 'Super Admin'])
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
</div>