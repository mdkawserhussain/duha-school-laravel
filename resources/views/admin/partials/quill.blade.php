{{-- Quill.js Rich Text Editor --}}
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<style>
    .ql-container {
        font-size: 14px;
        font-family: Helvetica, Arial, sans-serif;
    }
    .ql-editor {
        min-height: 300px;
    }
    .ql-toolbar {
        border-top: 1px solid #ccc;
        border-left: 1px solid #ccc;
        border-right: 1px solid #ccc;
        border-bottom: none;
        background: #fafafa;
    }
    .ql-container {
        border-bottom: 1px solid #ccc;
        border-left: 1px solid #ccc;
        border-right: 1px solid #ccc;
        border-top: none;
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill for all textareas with class 'quill-editor'
    document.querySelectorAll('textarea.quill-editor').forEach(function(textarea) {
        // Create a container div for Quill
        var container = document.createElement('div');
        container.id = 'quill-' + Math.random().toString(36).substr(2, 9);
        container.style.height = textarea.getAttribute('rows') ? (parseInt(textarea.getAttribute('rows')) * 24 + 'px') : '400px';
        
        // Insert container before textarea
        textarea.parentNode.insertBefore(container, textarea);
        
        // Hide textarea
        textarea.style.display = 'none';
        
        // Initialize Quill
        var quill = new Quill('#' + container.id, {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image'],
                    [{ 'color': [] }, { 'background': [] }],
                    ['clean'],
                    ['code-block']
                ]
            },
            placeholder: 'Start typing...',
        });
        
        // Set initial content
        if (textarea.value) {
            quill.root.innerHTML = textarea.value;
        }
        
        // Update textarea on text change
        quill.on('text-change', function() {
            textarea.value = quill.root.innerHTML;
        });
        
        // Image upload handler
        var toolbar = quill.getModule('toolbar');
        toolbar.addHandler('image', function() {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();
            
            input.onchange = function() {
                var file = input.files[0];
                if (file) {
                    // Validate file size (5MB max)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Image size must be less than 5MB');
                        return;
                    }
                    
                    // Validate file type
                    if (!file.type.match('image.*')) {
                        alert('Please select an image file');
                        return;
                    }
                    
                    // Show loading indicator
                    var range = quill.getSelection(true);
                    var index = range ? range.index : quill.getLength();
                    quill.insertText(index, 'Uploading image...', 'user');
                    quill.setSelection(index + 19);
                    
                    // Upload image
                    var formData = new FormData();
                    formData.append('file', file);
                    
                    // Get CSRF token
                    var token = document.querySelector('meta[name="csrf-token"]');
                    if (token) {
                        formData.append('_token', token.getAttribute('content'));
                    }
                    
                    fetch('{{ route("admin.media.upload") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    })
                    .then(function(response) {
                        if (!response.ok) {
                            throw new Error('Upload failed');
                        }
                        return response.json();
                    })
                    .then(function(data) {
                        // Remove loading text
                        quill.deleteText(index, 19);
                        
                        // Insert image
                        quill.insertEmbed(index, 'image', data.location);
                        quill.setSelection(index + 1);
                    })
                    .catch(function(error) {
                        // Remove loading text
                        quill.deleteText(index, 19);
                        alert('Image upload failed: ' + error.message);
                    });
                }
            };
        });
        
        // Store Quill instance for form submission
        textarea.quillInstance = quill;
    });
    
    // Update textarea values before form submission
    document.addEventListener('submit', function(e) {
        document.querySelectorAll('textarea.quill-editor').forEach(function(textarea) {
            if (textarea.quillInstance) {
                textarea.value = textarea.quillInstance.root.innerHTML;
            }
        });
    });
});
</script>

