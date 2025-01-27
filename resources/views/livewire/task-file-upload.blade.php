<div>
    <div wire:ignore class="filepond fp-bg-filled">
        <input 
            type="file" 
            id="filepond" 
            multiple 
        >
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        const inputElement = document.querySelector('#filepond');
        let filePondInstance;

        function initializeFilePond(savedFiles) {
            if (filePondInstance) {
                filePondInstance.destroy();
            }
            filePondInstance = FilePond.create(inputElement, {
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
                files: savedFiles.map(file => ({
                    source: file.file_path,
                    options: {
                        type: 'local',
                        file: {
                            size: file.file_size,
                            name: file.file_name,
                        }
                    }
                }))
            });
        }

        Livewire.on('savedFilesUpdated', savedFiles => {
            console.log('Updated savedFiles:', savedFiles);
            initializeFilePond(savedFiles);
        });

        // Initial load
        initializeFilePond(@json($savedFiles));
    });
</script>