@extends('admin.layouts.app')

@section('title', 'Introduction Section')
@section('page-title', 'Introduction Section')

@push('styles')
@include('admin.partials.quill')
@endpush

@section('content')
<div class="max-w-6xl">
    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    @include('admin.partials.cache-clear-button')

    <form action="{{ route('admin.homepage.introduction.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="introduction-form" novalidate>
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $section->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $section->subtitle) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('subtitle')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" maxlength="500" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">{{ old('description', $section->description) }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Brief description shown below the title (max 500 characters)</p>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea name="content" id="content" rows="10" class="quill-editor mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">{{ old('content', $section->content) }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Main content displayed in the introduction section (supports rich text formatting)</p>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Call to Action Button</h3>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="button_text" class="block text-sm font-medium text-gray-700">Button Text</label>
                    <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $section->button_text) }}" maxlength="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('button_text')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="button_link" class="block text-sm font-medium text-gray-700">Button Link</label>
                    <input type="text" name="button_link" id="button_link" value="{{ old('button_link', $section->button_link) }}" maxlength="255" placeholder="/about-us" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    <p class="mt-1 text-sm text-gray-500">URL path (e.g., /about-us)</p>
                    @error('button_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Images -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Images</h3>
            
            @if($section->hasMedia('images'))
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($section->getMedia('images') as $media)
                    <div class="relative group">
                        <img src="{{ $media->getUrl('medium') }}" alt="Introduction image" class="h-32 w-full object-cover rounded-lg">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity rounded-lg flex items-center justify-center">
                            <button 
                                type="button" 
                                class="delete-image-btn opacity-0 group-hover:opacity-100 transition-opacity px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700"
                                data-image-id="{{ $media->id }}"
                                data-delete-url="{{ route('admin.homepage.introduction.delete-image', $media->id) }}">
                                Delete
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div>
                <label for="images" class="block text-sm font-medium text-gray-700">Add Images</label>
                <input type="file" name="images[]" id="images" accept="image/*" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-za-green-primary file:text-white hover:file:bg-za-green-dark">
                <p class="mt-1 text-sm text-gray-500">You can upload multiple images. Images will be automatically converted to WebP format.</p>
                @error('images')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Active Status -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <label for="is_active" class="block text-sm font-medium text-gray-700">Active Status</label>
                    <p class="mt-1 text-sm text-gray-500">Show or hide this section on the homepage</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $section->is_active) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-za-green-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-za-green-primary"></div>
                </label>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" id="save-button" class="px-6 py-2 text-white font-semibold rounded-lg transition-colors shadow-md hover:shadow-lg" style="background-color: #008236;" onmouseover="this.style.backgroundColor='#0a4536'" onmouseout="this.style.backgroundColor='#008236'">
                Save Changes
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Introduction form script loaded');
    
    const form = document.getElementById('introduction-form');
    const saveButton = document.getElementById('save-button');
    
    if (!form) {
        console.error('Form not found!');
        return;
    }
    
    if (!saveButton) {
        console.error('Save button not found!');
        return;
    }
    
    console.log('Form and button found successfully');
    console.log('Button type:', saveButton.type);
    console.log('Form action:', form.action);
    
    // Handle button click directly
    saveButton.addEventListener('click', function(e) {
        console.log('Save button clicked');
        
        // Prevent default button behavior
        e.preventDefault();
        
        // Sync Quill content first
        try {
            document.querySelectorAll('textarea.quill-editor').forEach(function(textarea) {
                if (textarea.quillInstance) {
                    textarea.value = textarea.quillInstance.root.innerHTML;
                    console.log('Synced Quill content');
                }
            });
        } catch (error) {
            console.error('Error syncing Quill content:', error);
        }
        
        // Show loading state
        saveButton.disabled = true;
        saveButton.textContent = 'Saving...';
        
        console.log('Submitting form programmatically');
        
        // Submit the form programmatically
        form.submit();
    });
    
    // Handle delete image buttons
    document.querySelectorAll('.delete-image-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const imageId = this.getAttribute('data-image-id');
            const deleteUrl = this.getAttribute('data-delete-url');
            
            console.log('Delete button clicked for image:', imageId);
            
            if (confirm('Are you sure you want to delete this image?')) {
                console.log('User confirmed deletion, submitting to:', deleteUrl);
                
                // Create a form dynamically and submit it
                const deleteForm = document.createElement('form');
                deleteForm.method = 'POST';
                deleteForm.action = deleteUrl;
                
                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (csrfToken) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken.getAttribute('content');
                    deleteForm.appendChild(csrfInput);
                }
                
                // Append form to body and submit
                document.body.appendChild(deleteForm);
                deleteForm.submit();
            } else {
                console.log('User cancelled deletion');
            }
        });
    });
});
</script>
@endpush

@endsection

