<div>
    <x-search-header :project_title="$project->title" title="Task Statuses" searchModel="searchTerm" />
    <div class="flex items-center justify-between space-x-2 pl-2 pr-2 transition-all duration-[.25s]">
        <div class="w-full">
            <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
                <div>
                    <x-button color="info" wire:click="addNewStatus()">{{ __('Add new task status') }}</x-button>
                    <div class="card mt-3">
                        <div
                            class="is-scrollbar-hidden min-w-full overflow-x-auto"
                            x-data="pages.tables.initExample1"
                        >
                            <table class="is-hoverable w-full text-left">
                                <thead class="bg-blue-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                            {{ __('Status') }}
                                        </th>
                                        <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                            {{ __('Descripton') }}
                                        </th>
                                        <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                            {{ __('Kanban list rank') }}
                                        </th>
                                        <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                            {{ __('Updated') }}
                                        </th>
                                        <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                            {{ __('Action') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($statuses AS $index=>$status)
                                        <tr>
                                            <td class="px-6 py-3 text-[15px] font-medium text-{{$status->color}}-700 tracking-normal font-inter">
                                                {{$status->value}}
                                            </td>
                                            <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                                {{$status->description}}
                                            </td>
                                            <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                                {{$status->kanban_list_rank}}
                                            </td>
                                            <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                                {{ \Carbon\Carbon::parse($status->updated_at)->diffForHumans() }}
                                            </td>
                                            <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                                <div class="flex space-x-2">
                                                    <button wire:click="editStatus({{$status->id}})" 
                                                        class="btn h-8 w-8 p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button @click="
                                                        window.customConfirm({
                                                            title: 'Delete status',
                                                            message: 'Are you sure you want to delete this status? This action cannot be undone.',
                                                            color: 'red',
                                                            okText: 'Delete',
                                                        }).then(confirmed => {
                                                            if (confirmed) {
                                                                $dispatch('deleteConfirmed', { id: {{ $status->id }} });
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
                    {{ $statuses->links() }}
                </div>
            </div>   
        </div>
    </div>
</div>