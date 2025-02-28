<div x-data="{ isUploading: false }" class="p-6 bg-white rounded-lg shadow-md">
    <div class="flex flex-col space-y-4">
        <input type="file" wire:model="files" multiple x-ref="fileInput" class="hidden">
        
        <button type="button"
            @click="$refs.fileInput.click()"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none">
            {{ __('Select files to upload') }}
        </button> 
        @error('files.*') 
            <span class="text-red-500 text-sm">{{ $message }}</span> 
        @enderror
        @if (session()->has('message'))
            <div class="text-green-500 text-sm">{{ session('message') }}</div>
        @endif
    </div>
    <div wire:loading wire:target="files" class="text-sm text-gray-500 mt-2">
        Uploading files, please wait...
    </div>
    <div class="mt-6">
        <ul class="bg-white shadow-sm rounded-md divide-y divide-gray-200 mt-2">
            @foreach ($storedFiles as $index => $file)
                <li class="flex justify-between items-center p-3">
                    <a href="{{ $file['file_path'] }}" target="_blank"
                        class="text-blue-500 hover:text-blue-700">
                        <span class="text-sm text-gray-700">{{ $file['file_name'] }}</span> 
                    </a>
                    
                    <button @click="
                            window.customConfirm({
                                title: 'Remove file',
                                message: 'Are you sure you want to remove this file? This action cannot be undone.',
                                color: 'red',
                                okText: 'Remove',
                            }).then(confirmed => {
                                if (confirmed) {
                                    $dispatch('removeFileConfirmed', { id: {{ $file['id'] }} });
                                }
                            })
                        " 
                        class="btn h-8 w-8 p-0 text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                            <i class="fa fa-trash-alt"></i>
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
</div>
