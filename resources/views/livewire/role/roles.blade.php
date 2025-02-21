<div class="flex-grow flex flex-col">          
    @if(!$showRolePermission)    
    <main class="main-content">
        <div>
            <x-search-header title="Roles" searchModel="searchTerm" />
            <div class="flex items-center justify-between space-x-2 pl-2 pr-2 transition-all duration-[.25s]">
                <div class="w-full">
                    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
                        <x-app-partials.delete-confirmation />
                        <div>
                            <x-button color="info" wire:click="addNewRole()">{{ __('Add new role') }}</x-button>
                            <div class="card mt-3">
                                <x-status-message/>                            
                                <div
                                    class="is-scrollbar-hidden min-w-full overflow-x-auto"
                                    x-data="pages.tables.initExample1"
                                >
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-blue-200">
                                        <tr>
                                            <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                                {{ __('Role') }}</th>
                                            <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                                {{ __('Updated') }}</th>
                                            <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                                {{ __('Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($records as $record)
                                            <tr>
                                                <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                                    {{$record?->name}}
                                                </td>
                                                <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                                    {{ \Carbon\Carbon::parse($record->updated_at)->diffForHumans() }}
                                                </td>
                                                @if($record?->name != "Super Admin")
                                                <td class="px-2 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                    <a class="text-indigo-600 hover:text-indigo-900 cursor-pointer" wire:click.prevent="editRole({{$record->id}})">{{ __('Edit') }}</a>
                                                    |
                                                    <a class="text-green-600 hover:text-green-800 cursor-pointer" wire:click.prevent="grantPermissions({{$record->id}})">{{ __('Permissions') }}</a>
                                                    |
                                                    <a class="text-red-600 hover:text-red-800 cursor-pointer" wire:click.prevent="deleteRole({{$record->id}})">{{ __('Delete') }}</a>
                                                </td>
                                                @endif 
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
                        {{ $records->links() }}
                    </div>
                </div>
            </div>
            </div>
        </div>
    </main>
    @else
        @livewire('role.role-permissions', ['role_id' => $selectedRoleID])
    @endif
</div>