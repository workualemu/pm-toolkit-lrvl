<div>
    <div wire:ignore class="filepond fp-bg-filled">
        <input 
            type="file" 
            id="filepond" 
            name="files"
            wire:model="files"
            multiple 
        >
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        const inputElement = document.querySelector('#filepond');
        let filePondInstance = null;
        let temporaryFiles = [];

        function initializeFilePond(savedFiles) {
            if (!filePondInstance) {
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
                    
                });
            }

            // Update files in FilePond instance
            filePondInstance.setOptions({
                files: savedFiles.map(file => ({
                    source: file.id,
                    // source: file.file_path, // Provide the correct URL
                    options: {
                        type: 'local',
                        file: {
                            size: file.file_size,
                            name: file.file_name,
                        }
                    }
                }))
            });
            
            filePondInstance.on('processfile', (error, file) => {
                if (!error) {
                    // Check if serverId already exists in the array
                    if (!temporaryFiles.includes(file.serverId)) {
                        // Add serverId to the array
                        temporaryFiles.push(file.serverId);
                    }
                }
            });

            filePondInstance.on('removefile', (error, file) => {
                console.log('removefile event is called')
                if (error) {
                    console.error('Error while removing file:', error);
                } else {
                    // Emit a Livewire event to update the files array or delete from the database
                    const isSavedFile = savedFiles.some(savedFile => savedFile.id === file.serverId);
                    if (isSavedFile) {
                        Livewire.emit('fileDeleted', file.serverId);
                    } else {
                        Livewire.emit('fileRemoved', file.serverId);
                    }
                }
            });
        }


        function clearFilePond() {
            temporaryFiles.forEach(serverId => {
                filePondInstance.removeFile(serverId);
            });

            temporaryFiles = [];    
        }

        Livewire.on('savedFilesUpdated', savedFiles => {
            console.log('Saved Files Updated', savedFiles);
            initializeFilePond(savedFiles);
        });

        Livewire.on('clearFilePond', () => {
            clearFilePond();
        });
        
        Livewire.on('resetFilePond', () => {
            clearFilePond();
        });

        Livewire.on('fileDeleted', (fileId) => {
            console.log(`File with ID ${fileId} was deleted.`);
        });

        // Initial load
        const initialSavedFiles = @json($savedFiles);
        console.log('Saved Files', initialSavedFiles);
        initializeFilePond(initialSavedFiles);
    });
</script>