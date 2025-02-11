<div class="flex-grow flex flex-col">          
    @if(!$showUserRole)    
    <main class="main-content">
        <div
            class="flex justify-between space-x-2 px-2 py-2 transition-all duration-[.25s]">
            <div class="flex">
                <h3 class="text-lg font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                    {{ __('Registered users') }}
                </h3>
            </div>
            <label class="relative hidden w-full max-w-[16rem] sm:flex">
                <input wire:model.debounce.500ms="searchTerm"
                    class="form-input peer h-8 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 text-xs+ placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Search users" type="text" />
                <span
                    class="pointer-events-none absolute flex h-full w-9 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-colors duration-200"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z" />
                    </svg>
                </span>
            </label>
        </div>
        <div class="grid grid-cols-1 gap-4">
            <div class="col-span-1">

                <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
                    <div>
                        <div class="card mt-3">
                            @if($success < 0)
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                                    <strong class="font-bold">Error:</strong>
                                    <span class="block sm:inline">{{ $errorMessage }}!</span>
                                </div>
                            @elseif($success > 0)
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                                    <strong class="font-bold">Success:</strong>
                                    <span class="block sm:inline">Role assignment was completed successfully!</span>
                                </div>
                            @endif
                            <div
                                class="is-scrollbar-hidden min-w-full overflow-x-auto"
                                x-data="pages.tables.initExample1"
                            >
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Name') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Email') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Role') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Action') }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($records as $record)
                                    <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex text-left text-sm text-gray-500">
                                                {{$record->name}}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex text-left text-sm text-gray-500">
                                                {{$record?->email}}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex text-left text-sm text-gray-500">
                                                {{ $record->roles->pluck('name')->implode(', ') }}
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium text-gray-600">
                                            <a class="text-indigo-600 hover:text-indigo-900 cursor-pointer" wire:click.prevent="editUser({{$record->id}})">{{ __('Edit') }}</a>
                                            |
                                                <a class="text-green-600 hover:text-green-800 cursor-pointer" wire:click.prevent="assignRoles({{$record->id}})">{{ __('Roles') }}</a>
                                                |
                                            <a class="text-red-600 hover:text-red-800 cursor-pointer" wire:click.prevent="deleteUser({{$record->id}})">{{ __('Delete') }}</a>
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
        </div>
    </main>
    @else
        @livewire('role.user-roles', ['user_id' => $selectedUserID])
    @endif
</div>
