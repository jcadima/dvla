<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

<script>
// Generic Summernote component that can handle different content field names
$(document).ready(function() {
    
    $('.summernote').each(function() {
        var $textarea = $(this);
        var textareaName = $textarea.data('textarea-name') || 'page_content'; // Default fallback
        var height = $textarea.data('height') || 250; // Default height

        $textarea.summernote({
            tabsize: 2,
            height: height,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onInit: function() {
                },
                onChange: function(contents, $editable) {
                    
                    // Use Livewire's wire:model to set the corresponding property
                    @this.set(textareaName, contents);
                },

                onImageUpload: function(files) {
                    
                    // Handle image upload
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        
                        const reader = new FileReader();

                        reader.onloadend = function() {
                            
                            // Create a temporary image to get dimensions
                            const img = new Image();
                            img.onload = function() {
                                
                                // Create a unique filename
                                const filename = Date.now() + '_' + file.name;

                                // Create the image element with the ACTUAL base64 data and filename attribute
                                const $image = $('<img>').attr({
                                    'src': reader.result, // Use the actual base64 data
                                    'data-filename': filename,
                                    'class': 'img-fluid' // Use Bootstrap's responsive image class
                                });
                                
                                // Insert the image into the editor
                                $textarea.summernote('insertNode', $image[0]);

                                // Now trigger the image processing
                                setTimeout(() => {
                                    processImagesInEditor($textarea, textareaName);
                                }, 100);
                            };
                            img.onerror = function() {
                                console.error('Failed to load image:', file.name);
                            };
                            img.src = reader.result;
                        };
                        
                        reader.onerror = function() {
                            console.error('FileReader error for:', file.name);
                        };
                        
                        reader.readAsDataURL(file);
                    }
                },
                onPaste: function(e) {
                    
                    // Handle pasted images
                    const clipboardData = e.originalEvent.clipboardData;
                    if (clipboardData && clipboardData.items) {
                        
                        for (let i = 0; i < clipboardData.items.length; i++) {
                            const item = clipboardData.items[i];
                            
                            if (item.type.indexOf('image') !== -1) {
                                const file = item.getAsFile();
                                if (file) {
                                    // Process the pasted image
                                    setTimeout(() => {
                                        processImagesInEditor($textarea, textareaName);
                                    }, 100);
                                } else {
                                }
                            }
                        }
                    } else {
                    }
                }
            }
        });
        
    });
    
});

// Function to process images in the editor and upload them
function processImagesInEditor(editor, contentFieldName) {
    
    const content = editor.summernote('code');
    
    // Check if there are any base64 images in the content
    if (content.includes('data:image/')) {
        
        // Update the Livewire component's content field
        @this.set(contentFieldName, content);
        
        // Call the Livewire method to process and upload images
        @this.call('uploadImage');
    } else {
    }
    
}

// Listen for the imageProcessed event from Livewire
document.addEventListener('livewire:initialized', () => {
    
    @this.on('imageProcessed', (event) => {
        
        // Try different ways to access the content
        let content = null;
        if (event && event.content) {
            content = event.content;
        } else if (event && event.detail && event.detail.content) {
            content = event.detail.content;
        } else if (event && typeof event === 'string') {
            content = event;
        } else {
            console.error('Could not find content in event:', event);
            return;
        }
        
        // Find the active summernote editor and update it
        $('.summernote').each(function() {
            const $editor = $(this);
            const textareaName = $editor.data('textarea-name') || 'page_content';
            
            // Update the editor with the processed content
            $editor.summernote('code', content);
        });
        
    });
    
});

// Add event listener for image uploads via drag and drop
$(document).on('summernote.image.uploaded', '.summernote', function() {
    
    const $editor = $(this);
    const textareaName = $editor.data('textarea-name') || 'page_content';
    
    setTimeout(() => {
        processImagesInEditor($editor, textareaName);
    }, 100);
});

// Add event listener for source code mode changes
$(document).on('summernote.codeview.toggled', '.summernote', function() {
    
    const $editor = $(this);
    const textareaName = $editor.data('textarea-name') || 'page_content';
    
    // Add a small delay to ensure the mode switch is complete
    setTimeout(() => {
        const contents = $editor.summernote('code');
        
        @this.set(textareaName, contents);
    }, 100);
});

// Add event listener for save button clicks to sync content in source code mode
$(document).on('click', 'button[type="submit"], input[type="submit"]', function() {
    
    // Find any active summernote editors
    $('.summernote').each(function() {
        const $editor = $(this);
        const textareaName = $editor.data('textarea-name') || 'page_content';
        
        // Check if we're in source code mode
        const isCodeView = $editor.summernote('codeview.isActivated');
        
        if (isCodeView) {
            // Force sync the content before form submission
            const contents = $editor.summernote('code');
            
            @this.set(textareaName, contents);
        }
    });
});

</script> 