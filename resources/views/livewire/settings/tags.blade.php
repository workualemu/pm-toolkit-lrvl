<div>
    <x-search-header title="Tags" searchModel="searchTerm" />
    <div class="flex items-center justify-between space-x-2 pl-2 pr-2 transition-all duration-[.25s]">
        <div class="w-full">
            <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
                <div>
                    <x-button color="info" wire:click="addNewTag()">{{ __('Add new tag') }}</x-button>

                    <div class="card mt-3">
                        <div
                            class="is-scrollbar-hidden min-w-full overflow-x-auto"
                            x-data=""
                        >
                            <table class="is-hoverable w-full text-left">
                                <thead class="bg-blue-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                            {{ __('Tag') }}
                                        </th>
                                        <th scope="col" class="px-6 py-2 text-left text-slate-800 uppercase font-montserrat">
                                            {{ __('Descripton') }}
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
                                    @foreach($tags AS $index=>$tag)
                                        <tr>
                                            <td class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100 lg:px-5">
                                                <div class="bg-{{$tag->color}}-600 badge text-white">
                                                    {{$tag->label}}
                                                </div>
                                            </td>
                                            <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                                {{$tag->description}}
                                            </td>
                                            <td class="px-6 py-3 text-[15px] font-medium text-gray-800 tracking-normal font-inter">
                                                {{ \Carbon\Carbon::parse($tag->updated_at)->diffForHumans() }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-2 sm:px-5 relative">
                                                <div class="flex space-x-2">
                                                    <button wire:click="editTag({{$tag->id}})" 
                                                        class="btn h-8 w-8 p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button @click="
                                                        window.customConfirm({
                                                            title: 'Delete tag',
                                                            message: 'Are you sure you want to delete this tag? This action cannot be undone.',
                                                            color: 'red',
                                                            okText: 'Delete',
                                                        }).then(confirmed => {
                                                            if (confirmed) {
                                                                $dispatch('deleteConfirmed', { id: {{ $tag->id }} });
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
                        {{ $tags->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>