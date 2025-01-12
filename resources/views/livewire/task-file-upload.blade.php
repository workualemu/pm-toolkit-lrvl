<div>
    <div wire:ignore class="filepond fp-bg-filled">
        <input 
            type="file" 
            id="filepond" 
            multiple 
            x-init="
                $el._x_filepond = FilePond.create($el, {
                    credits: false,
                    allowRevert: true, // Allow removing uploaded files from the list
                    server: {
                        process: (fieldName, file, metadata, load, error, progress, abort) => {
                            @this.upload('files', file, load, error, progress);
                        },
                        revert: (filename, load) => {
                            @this.removeUpload('files', filename, load);
                        },
                        load: (source, load, error, progress, abort, headers) => {
                            fetch(source)
                                .then((res) => res.blob())
                                .then(load);
                        }
                    },
                    files: [
                        @foreach($savedFiles as $file)
                            {
                                source: '{{ $file['file_path'] }}',
                                options: {
                                    type: 'local',
                                    file: {
                                        size: {{ $file['file_size'] }},
                                        name: '{{ $file['file_name'] }}',
                                    }
                                }
                            },
                        @endforeach
                    ]
                });
            "
        >
    </div>
    <!-- List saved files -->
    <div class="mt-4">
        <ul>
            @foreach ($uploadedFiles as $file)
                <li>
                    <a href="{{ Storage::url($file->file_path) }}" target="_blank">
                        {{ basename($file->file_path) }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    @if (session()->has('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:load', () => {
        // Register FilePond plugins (optional)
        

        // Get the FilePond input element
        const inputElement = document.querySelector('#filepond');

        if (inputElement) {
            // Create a FilePond instance
            const pond = FilePond.create(inputElement, {
                credits: false,
                acceptedFileTypes: ['image/*', 'application/pdf'], // Restrict file types
                maxFileSize: '10MB', // Restrict max file size
                // Livewire integration
                server: {
                    process: (fieldName, file, metadata, load, error, progress, abort) => {
                        // Livewire file upload handler
                        @this.upload('files', file, load, error, progress);
                    },
                    revert: (filename, load) => {
                        // Livewire file removal handler
                        @this.removeUpload('files', filename, load);
                    },
                },
            });

            // Reset FilePond instance when Livewire updates the DOM
            // Livewire.on('resetFilePond', () => {
            //     pond.removeFiles();
            // });
        }
    });
</script>
