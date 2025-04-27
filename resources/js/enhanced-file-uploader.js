document.addEventListener('DOMContentLoaded', function() {
    // Global storage for all uploaded files
    const allUploadedFiles = new Map(); 
    
    // Initialize all file upload components
    document.querySelectorAll('.file-upload-container').forEach(container => {
        initializeFileUploader(container);
    });
    
    function initializeFileUploader(container) {
        const fileInput = container.querySelector('input[type="file"]');
        const previewContainer = container.querySelector('.file-preview-container') || createPreviewContainer();
        const errorContainer = container.querySelector('.error-container') || createErrorContainer();
        
        // Insert preview and error containers if they don't exist
        if (!container.querySelector('.file-preview-container')) {
            container.appendChild(previewContainer);
        }
        if (!container.querySelector('.error-container')) {
            container.appendChild(errorContainer);
        }
        
        // Store files for this specific input
        const inputFiles = new Map();
        
        fileInput.addEventListener('change', function(event) {
            // Clear previous errors
            errorContainer.textContent = '';
            errorContainer.classList.add('hidden');
            
            const files = event.target.files;
            
            if (!files || files.length === 0) return;
            
            let duplicateFound = false;
            
            // Process each selected file
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const fileId = `${file.name}-${file.size}-${file.lastModified}`;
                
                // Check if this file is already uploaded anywhere in the form
                if (allUploadedFiles.has(fileId)) {
                    errorContainer.textContent = `Error: "${file.name}" has already been uploaded.`;
                    errorContainer.classList.remove('hidden');
                    duplicateFound = true;
                    break;
                }
                
                // Add file to our tracking maps
                inputFiles.set(fileId, file);
                allUploadedFiles.set(fileId, file);
                
                // Create preview element
                createFilePreview(file, fileId, previewContainer, inputFiles);
            }
            
            if (duplicateFound) {
                // Reset the file input
                fileInput.value = '';
            }
        });
        
        // Create containers for file previews and errors
        function createPreviewContainer() {
            const div = document.createElement('div');
            div.className = 'file-preview-container mt-2 flex flex-wrap gap-2';
            return div;
        }
        
        function createErrorContainer() {
            const div = document.createElement('div');
            div.className = 'error-container text-sm text-red-600 mt-1 hidden';
            return div;
        }
        
        function createFilePreview(file, fileId, previewContainer, inputFiles) {
            const previewElement = document.createElement('div');
            previewElement.className = 'relative bg-gray-100 p-2 rounded-md flex items-center';
            
            // File icon or thumbnail
            const iconElement = document.createElement('div');
            iconElement.className = 'mr-2 text-blue-500';
            iconElement.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" /></svg>';
            
            // File name with truncation
            const nameElement = document.createElement('div');
            const fileName = file.name.length > 15 ? file.name.substring(0, 12) + '...' : file.name;
            nameElement.textContent = fileName;
            nameElement.className = 'text-xs';
            nameElement.title = file.name;
            
            // Remove button
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'ml-2 text-red-500 hover:text-red-700';
            removeButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>';
            
            removeButton.addEventListener('click', function() {
                // Remove from our tracking maps
                inputFiles.delete(fileId);
                allUploadedFiles.delete(fileId);
                
                // Remove preview element
                previewElement.remove();
                
                // Reset the file input if needed
                // This is tricky since we can't directly modify FileList
                // Consider using a hidden input to track the actual files to be submitted
            });
            
            // Assemble the preview
            previewElement.appendChild(iconElement);
            previewElement.appendChild(nameElement);
            previewElement.appendChild(removeButton);
            
            previewContainer.appendChild(previewElement);
        }
    }
});