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
                    source: file.file_path,
                    options: {
                        type: 'local',
                        filename: file.file_name,
                        metadata: {
                            id: file.id,
                            name: file.file_name,
                        },
                    }
                }))
            });

            filePondInstance.on('addfile', (error, file) => {
                if (!error) {
                    const metadata = file.getMetadata();
                    if (metadata && metadata.name) {
                        console.log('Before:', file.filename); // Check before renaming
                        // Update FilePond's internal metadata
                        file.setMetadata('file_name', metadata.name, true);
                        console.log('file', file);
                        console.log('After:', file.getMetadata('file_name'), file.filename); 
                    }
                }
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
                if (error) {
                    console.error('Error while removing file:', error);
                } else {
                    // Emit a Livewire event to update the files array or delete from the database
                    const isSavedFile = savedFiles.some(savedFile => savedFile.file_path === file.serverId);
                    if (isSavedFile) {
                        // Livewire.emit('fileDeleted', file.serverId);
                        Livewire.emit('trackUnsavedFiles', file.getMetadata('id'));
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
            
            Livewire.emit('resetTrackingUnsavedFiles')
        }

        Livewire.on('savedFilesUpdated', savedFiles => {
            initializeFilePond(savedFiles);
        });

        Livewire.on('clearFilePond', () => {
            clearFilePond();
        });
        
        Livewire.on('resetFilePond', () => {
            clearFilePond();
        });

        // Livewire.on('fileDeleted', (fileId) => {
        //     console.log(`File with ID ${fileId} was deleted.`);
        // });

        // Initial load
        const initialSavedFiles = @json($savedFiles);
        initializeFilePond(initialSavedFiles);
    });
</script>