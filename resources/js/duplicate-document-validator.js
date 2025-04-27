document.addEventListener('DOMContentLoaded', function() {
    // Store uploaded file names to check for duplicates
    let uploadedFiles = new Set();
    
    // Get all file input elements
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        // Create an error message container after each file input
        const errorContainer = document.createElement('div');
        errorContainer.className = 'text-sm text-red-600 mt-1 hidden';
        input.parentNode.insertBefore(errorContainer, input.nextSibling);
        
        input.addEventListener('change', function(event) {
            // Hide any previous error messages
            errorContainer.classList.add('hidden');
            errorContainer.textContent = '';
            
            const files = event.target.files;
            
            if (!files || files.length === 0) return;
            
            // Check for duplicates
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                
                // Create a unique identifier for the file (name + size + last modified)
                const fileIdentifier = `${file.name}-${file.size}-${file.lastModified}`;
                
                if (uploadedFiles.has(fileIdentifier)) {
                    // Show error message
                    errorContainer.textContent = `Error: "${file.name}" has already been uploaded.`;
                    errorContainer.classList.remove('hidden');
                    
                    // Clear the file input
                    event.target.value = '';
                    return;
                }
                
                // Add the file to our set of uploaded files
                uploadedFiles.add(fileIdentifier);
            }
        });
    });
});