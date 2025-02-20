<div>
    <x-search-header title="Task Priorities" searchModel="searchTerm" />
    <div class="flex items-center justify-between space-x-2 pl-2 pr-2 transition-all duration-[.25s]">
        <div class="w-full">
            <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
                <x-app-partials.delete-confirmation />
                <div>
                    <x-button color="info" wire:click="addNewPriority()">{{ __('Add new priority') }}</x-button>
                    <div class="card mt-3">
                        <div
                            class="is-scrollbar-hidden min-w-full overflow-x-auto"
                            x-data=""
                        >
                            <table class="is-hoverable w-full text-left">
                                <thead class="bg-blue-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                            {{ __('Priority') }}
                                        </th>
                                        <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                            {{ __('Descripton') }}
                                        </th>
                                        <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                                {{ __('Updated') }}</th>
                                        <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                            {{ __('Action') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($records AS $index=>$priority)
                                        <tr>
                                            <td class="px-6 py-3 text-[15px] font-medium text-{{$priority->color}}-700 tracking-normal font-inter">
                                                {{$priority->value}}
                                            </td>
                                            <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                                {{$priority->description}}
                                            </td>
                                            <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                                {{ \Carbon\Carbon::parse($priority->updated_at)->diffForHumans() }}
                                            </td>
                                            <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                                <div class="flex space-x-2">
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
                        {{ $records->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>