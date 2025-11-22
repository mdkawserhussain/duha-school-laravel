@extends('admin.layouts.app')

@section('title', 'Edit Event')
@section('page-title', 'Edit Event')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Event Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Event Information</h3>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary @error('title') border-red-300 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $event->slug) }}" pattern="[a-z0-9_-]+" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary @error('slug') border-red-300 @enderror">
                    <p class="mt-1 text-xs text-gray-500">URL-friendly identifier. Leave empty to auto-generate from title.</p>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700">Excerpt</label>
                    <textarea name="excerpt" id="excerpt" rows="3" maxlength="500" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary @error('excerpt') border-red-300 @enderror">{{ old('excerpt', $event->excerpt) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Brief summary shown in listings (max 500 characters)</p>
                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="content" class="block text-sm font-medium text-gray-700">Content <span class="text-red-500">*</span></label>
                    <textarea name="content" id="content" rows="10" class="quill-editor mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary @error('content') border-red-300 @enderror">{{ old('content', $event->content) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Rich text editor will be integrated here (Phase 8)</p>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary @error('location') border-red-300 @enderror">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Event Schedule -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Event Schedule</h3>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="start_at" class="block text-sm font-medium text-gray-700">Start Date & Time <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="start_at" id="start_at" value="{{ old('start_at', $event->start_at ? $event->start_at->format('Y-m-d\TH:i') : '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary @error('start_at') border-red-300 @enderror">
                    @error('start_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_at" class="block text-sm font-medium text-gray-700">End Date & Time</label>
                    <input type="datetime-local" name="end_at" id="end_at" value="{{ old('end_at', $event->end_at ? $event->end_at->format('Y-m-d\TH:i') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary @error('end_at') border-red-300 @enderror">
                    @error('end_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary @error('category') border-red-300 @enderror">
                        <option value="">Select category</option>
                        <option value="Academic" {{ old('category', $event->category) === 'Academic' ? 'selected' : '' }}>Academic</option>
                        <option value="Social" {{ old('category', $event->category) === 'Social' ? 'selected' : '' }}>Social</option>
                        <option value="Islamic" {{ old('category', $event->category) === 'Islamic' ? 'selected' : '' }}>Islamic</option>
                        <option value="Sports" {{ old('category', $event->category) === 'Sports' ? 'selected' : '' }}>Sports</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $event->is_featured) ? 'checked' : '' }} class="rounded border-gray-300 text-za-green-primary focus:ring-za-green-primary">
                    <label for="is_featured" class="ml-2 block text-sm text-gray-700">
                        Featured Event
                    </label>
                </div>
            </div>
        </div>

        <!-- Publishing -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Publishing</h3>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                    <select name="status" id="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary @error('status') border-red-300 @enderror">
                        @php
                            $currentStatus = $event->status ?? ($event->is_published ? 'published' : 'draft');
                        @endphp
                        <option value="draft" {{ old('status', $currentStatus) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $currentStatus) === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ old('status', $currentStatus) === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700">Publish At <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $event->published_at ? $event->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary @error('published_at') border-red-300 @enderror">
                    @error('published_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Media -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Media</h3>
            <div class="space-y-6">
                @if($event->hasMedia('featured_image'))
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Featured Image</label>
                    <img src="{{ $event->getFirstMediaUrl('featured_image', 'medium') }}" alt="Featured image" class="h-32 w-auto rounded-lg">
                </div>
                @endif
                <div>
                    <label for="featured_image" class="block text-sm font-medium text-gray-700">Featured Image</label>
                    <input type="file" name="featured_image" id="featured_image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-za-green-primary file:text-white hover:file:bg-za-green-dark">
                    <p class="mt-1 text-xs text-gray-500">Max 5MB. Leave empty to keep current image.</p>
                    @error('featured_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if($event->hasMedia('gallery'))
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Gallery Images</label>
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($event->getMedia('gallery') as $media)
                        <div class="relative">
                            <img src="{{ $media->getUrl('thumb') }}" alt="Gallery image" class="h-24 w-full object-cover rounded-lg">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                <div>
                    <label for="gallery" class="block text-sm font-medium text-gray-700">Add Gallery Images</label>
                    <input type="file" name="gallery[]" id="gallery" accept="image/*" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-za-green-primary file:text-white hover:file:bg-za-green-dark">
                    <p class="mt-1 text-xs text-gray-500">Multiple images allowed. Max 5MB each.</p>
                    @error('gallery')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="bg-gray-50 border-t border-gray-200 shadow-lg rounded-lg p-6 mt-6 sticky bottom-0 z-10">
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('admin.events.index') }}" class="px-4 py-2 border-2 border-gray-400 rounded-lg text-gray-800 bg-white hover:bg-gray-100 hover:border-gray-500 transition-colors font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors shadow-md hover:shadow-lg">
                    Update Event
                </button>
            </div>
        </div>
    </form>
</div>

@push('quill')
@include('admin.partials.quill')
@endpush
@endsection

