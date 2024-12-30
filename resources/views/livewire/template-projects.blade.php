<main class="w-full px-2 pt-16 mb-[60px] md:ml-[var(--main-sidebar-width)] ">
    <livewire:template-projects-modal />
    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
        <div>
            <div class="px-2 flex items-center justify-between">
                <div>
                    <button wire:click="addNewTemplate()"
                        class="border-b border-dotted border-current pb-0.5 font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70"
                    >
                        {{ __('Add new project template') }}
                    </button>
                </div>
            </div>

            <div class="card mt-3">
                <div class="is-scrollbar-hidden min-w-full overflow-x-auto" x-data="pages.tables.initExample1">
                    <table class="min-w-full divide-y divide-gray-200" wire:model="records">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Name') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Duration') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Status') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($templates as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center text-sm text-gray-500">
                                            {{$record->title}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center text-sm text-gray-500">
                                            {{$record->duration}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center text-sm text-gray-500">
                                            {{$record->status}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-400">
                                        <a class="text-indigo-600 hover:text-indigo-900 cursor-pointer" wire:click.prevent="editTemplate({{$record->id}})">{{ __('Edit') }}</a>
                                        |
                                        <a class="text-red-600 hover:text-red-800 cursor-pointer" wire:click.prevent="deleteTemplate({{$record->id}})">{{ __('Delete') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex justify-center text-sm text-gray-500">
                                            {{ __('No records to display') }}
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
