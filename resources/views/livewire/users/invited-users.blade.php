<div>
    <x-search-header title="Invitations" searchModel="searchTerm" />
    <div class="flex items-center justify-between space-x-2 pl-2 pr-2 transition-all duration-[.25s]">
        <div class="w-full">
            <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
                <div>
                    <x-button color="info" wire:click="addNewInvitation()">{{ __('Invite user') }}</x-button>
                    <div class="card mt-3">
                        <div
                            class="is-scrollbar-hidden min-w-full overflow-x-auto"
                            x-data="pages.tables.initExample1"
                        >
                        <table class="min-w-full divide-y divide-gray-200" wire:model="records">
                            <thead class="bg-blue-200">
                                <tr>
                                    <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                        {{ __('Email') }}
                                    </th>
                                    <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                        {{ __('Status') }}
                                    </th>
                                    <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($records as $record)
                                <tr>
                                    <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                        {{$record->email}}
                                    </td>
                                    <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                        {{$record->status}}
                                    </td>
                                    <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                        <a class="text-indigo-600 hover:text-indigo-900 cursor-pointer" wire:click.prevent="showLink({{$record->id}})">{{ __('Edit') }}</a>
                                        |
                                        <a class="text-red-600 hover:text-red-800 cursor-pointer" 
                                            @click.prevent="
                                                window.customConfirm({
                                                        title: 'Delete invitation',
                                                        message: 'Are you sure you want to delete this invitation? ',
                                                        color: 'red',
                                                        okText: 'Delete',
                                                    }).then(confirmed => {
                                                        if (confirmed) {
                                                            $dispatch('deleteConfirmed', { id: {{ $record->id }} });
                                                        }
                                                    })
                                                "
                                        >
                                            {{ __('Delete') }}
                                        </a>
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
                    {{ $records->links() }}
                </div>
            </div>
        </div>
    </div>
</div>