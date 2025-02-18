<div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
    <x-app-partials.delete-confirmation />
    <div>
        <div class="">
            <div>
                <button wire:click="addNewTemplate()"
                    class="border-b border-dotted border-current pb-0.5 font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70"
                >
                    {{ __('Add new project template') }}
                </button>
            </div>
        </div>

        <div class="card mt-3">
            <div class="is-scrollbar-hidden min-w-full overflow-x-auto" 
                x-data="">
                <table class="min-w-full divide-y divide-gray-200" wire:model="records">
                    <thead class="bg-blue-200">
                        <tr>
                            <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                {{ __('Name') }}
                            </th>
                            <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                {{ __('Duration') }}
                            </th>
                            <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                {{ __('Status') }}
                            </th>
                            <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                {{ __('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($templates as $record)
                            <tr>
                                <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                    {{$record->title}}
                                </td>
                                <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                    {{$record->duration}}
                                </td>
                                <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                    {{$record->status}}
                                </td>
                                <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                    <div class="flex space-x-2">
                                        <button wire:click="editTemplate({{$record->id}})" 
                                            class="btn h-8 w-8 p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button @click="
                                            window.customConfirm({
                                                title: 'Delete template',
                                                message: 'Are you sure you want to delete this template? This action cannot be undone.',
                                                color: 'red',
                                                okText: 'Delete',
                                            }).then(confirmed => {
                                                if (confirmed) {
                                                    $dispatch('deleteConfirmed', { id: {{ $record->id }} });
                                                }
                                            })
                                        " 
                                        class="btn h-8 w-8 p-0 text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-3 whitespace-nowrap">
                                    <div class="flex justify-center text-sm text-slate-500">
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
