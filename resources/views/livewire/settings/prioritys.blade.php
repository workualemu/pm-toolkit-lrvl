<div x-data="" 
    class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
    <x-app-partials.delete-confirmation />
    <div>
        <div class="flex items-center justify-between">
            
            <div>
                <button wire:click="addNewPriority()"
                    class="border-b border-dotted border-current pb-0.5 font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70"
                >
                    {{ __('Add new priority') }}
                </button>
            </div>
        </div>
        <div class="card mt-3">
            <div
                class="is-scrollbar-hidden min-w-full overflow-x-auto"
                x-data="pages.tables.initExample1"
            >
                <table class="is-hoverable w-full text-left">
                    <thead>
                        <tr>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                            >
                                {{ __('Priority') }}
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                            >
                                {{ __('Descripton') }}
                            </th>
                            <th
                                class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                            >
                                {{ __('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prioritys AS $index=>$priority)
                            <tr>
                                <td
                                    class="whitespace-nowrap px-3 py-3 font-medium text-{{$priority->color}}-700 dark:text-navy-100 lg:px-5"
                                >
                                    {{$priority->value}}
                                </td>
                                <td
                                    class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100 lg:px-5"
                                >
                                {{$priority->description}}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5 relative">
                                    <div class="flex justify-center space-x-2">
                                        <button wire:click="editPriority({{$priority->id}})" 
                                            class="btn h-8 w-8 p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button @click="
                                            window.customConfirm({
                                                title: 'Delete priority',
                                                message: 'Are you sure you want to delete this priority? This action cannot be undone.',
                                                color: 'red',
                                                okText: 'Delete',
                                            }).then(confirmed => {
                                                if (confirmed) {
                                                    $dispatch('deleteConfirmed', { id: {{ $priority->id }} });
                                                }
                                            })
                                        " 
                                        class="btn h-8 w-8 p-0 text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                        
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>