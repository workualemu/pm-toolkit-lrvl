<div>
    <x-search-header title="Permissions" searchModel="searchTerm" />
    <p class="mt-1 text-xs p-2">{{ __('For role: ') }} {{ $role->name }}</p>
    <div class="grid grid-cols-4 gap-4 sm:grid-cols-2 sm:gap-5 lg:gap-6">
        <div class="sm:col-span-2">
            <div class="mt-2 grid grid-cols-1 gap-4 sm:grid-cols-4 sm:gap-5 lg:gap-6">
                @foreach($permissions as $permission)
                    <label class="inline-flex items-center space-x-2">
                        <input wire:model="grantedPermissions.{{$permission->id}}"
                            class="form-switch h-5 w-10 rounded-full bg-slate-300 before:rounded-full before:bg-slate-50 checked:!bg-info checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:before:bg-white"
                            type="checkbox"
                            id="{{$permission->id}}"
                            name="{{$permission->id}}"
                        />
                        <p>{{$permission->name}}</p>
                    </label>
                @endforeach
            </div>
        </div>
    </div>
    <div class="py-4"></div>
    <div class="items-center border-t border-slate-150 py-3 dark:border-navy-600">
        <div class="px-2 flex items-center justify-between dark:border-navy-600">
            <x-button color="error" wire:click="grantPermissions(false)">
                {{ __('Close') }}
            </x-button>
            <x-button color="info" wire:click="grantPermissions(true)">
                {{ __('Save') }}
            </x-button>
        </div>
    </div>
</div>
