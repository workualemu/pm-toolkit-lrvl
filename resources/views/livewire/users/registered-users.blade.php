
<div>
    @if(!$showUserRole)
    <x-search-header title="Registered users" searchModel="searchTerm" />
    <div class="flex items-center justify-between space-x-2 pl-2 pr-2 transition-all duration-[.25s]">
        <div class="w-full">
            <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
                <div>
                    <x-button color="info" wire:click="inviteUser()">{{ __('Invite user') }}</x-button>
                    <div class="card mt-3">
                        <div
                            class="is-scrollbar-hidden min-w-full overflow-x-auto"
                            x-data="pages.tables.initExample1"
                        >
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-200">
                            <tr>
                                <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                    {{ __('Name') }}
                                </th>
                                <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                    {{ __('Email') }}
                                </th>
                                <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                    {{ __('Role') }}
                                </th>
                                <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                    {{ __('Action') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($records as $record)
                                <tr>
                                    <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                            {{$record->name}}
                                    </td>
                                    <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                            {{$record?->email}}
                                    </td>
                                    <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                            {{ $record->roles->pluck('name')->implode(', ') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium text-gray-600">
                                            <a class="text-green-600 hover:text-green-800 cursor-pointer" wire:click.prevent="assignRoles({{$record->id}})">{{ __('Roles') }}</a>
                                            |
                                        <a class="text-red-600 hover:text-red-800 cursor-pointer" 
                                            @click.prevent="
                                                window.customConfirm({
                                                        title: '{{ $record->suspend_action }} user',
                                                        message: 'Are you sure you want to {{ $record->suspend_action }} this user? ',
                                                        color: 'sky',
                                                        okText: '{{ $record->suspend_action }}',
                                                    }).then(confirmed => {
                                                        if (confirmed) {
                                                            $dispatch('suspendConfirmed', { id: {{ $record->id }} });
                                                        }
                                                    })
                                                "
                                        >
                                            {{ $record->suspend_action }}
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
                </div>
            </div>
        </div>
    @else
        @livewire('users.user-roles', ['user_id' => $selectedUserID])
    @endif
</div>
