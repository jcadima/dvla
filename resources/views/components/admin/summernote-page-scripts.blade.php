<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

<script>
// Custom Summernote for Pages
    $('#summernote').summernote({
        tabsize: 4,
        height: 450,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        codeviewFilter: false, // Disable filtering in code view to allow HTML/JS without sanitizing
        codeviewIframeFilter: true, // Enable iframe content filtering for code view
        codeviewFilterRegex: /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, // Sanitize scripts in code view
        callbacks: {
            onInit: function() {
                // Switch to code view right after Summernote initializes
                //$('#summernote').summernote('codeview.toggle');
            },
            onChange: function(contents, $editable) {
                if (contents === this.page_content || contents === window) {
                    return;
                }
                @this.set('page_content', contents);
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

                            // Create the image element with the file path instead of base64
                            const $image = $('<img>').attr({
                                'src': '/pages/' + filename,
                                'data-filename': filename
                            }).css({
                                'width': Math.min($('#summernote').width(), img.width)
                            });

                            // Insert the image into the editor
                            $('#summernote').summernote('insertNode', $image[0]);

                            // Here you would typically upload the file to your server
                            // and get back the URL, but for this example we're just
                            // using the filename as the path
                        };
                        img.src = reader.result;
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
                                    processImagesInEditor();
                                }, 100);
                            }
                        }
                    }
                }
            }
        },
        codeviewEditable: true,// Allow direct editing in code view mode
    }); // end summernote

    // Function to process images in the editor and upload them
    function processImagesInEditor() {
        const editor = $('#summernote');
        const content = editor.summernote('code');
        
        // Check if there are any base64 images in the content
        if (content.includes('data:image/')) {
            // Update the Livewire component's page_content
            @this.set('page_content', content);
            
            // Call the Livewire method to process and upload images
            @this.call('uploadImage');
        }
    }

    // Listen for the imageProcessed event from Livewire
    document.addEventListener('livewire:initialized', () => {
        @this.on('imageProcessed', (event) => {
            const editor = $('#summernote');
            // Update the editor with the processed content
            editor.summernote('code', event.content);
        });
    });

    // Listen for form submission to sync code view content if active
    document.addEventListener("submit", function() {
        if ($('#summernote').summernote('codeview.isActivated')) {
            // If in code view, get the content from the code view textarea
            var codeContent = $('.note-codable').val(); // Target the code view textarea
            @this.set('page_content', codeContent);
        }
    });

    // Add event listener for image uploads via drag and drop
    $('#summernote').on('summernote.image.uploaded', function() {
        setTimeout(() => {
            processImagesInEditor();
        }, 100);
    });
</script>
