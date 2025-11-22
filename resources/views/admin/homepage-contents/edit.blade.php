@extends('admin.layouts.app')

@section('title', 'Edit Homepage Content')
@section('page-title', 'Edit Homepage Content')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.homepage-contents.update', $content) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Content Information</h3>
            <div class="space-y-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="section_key" class="block text-sm font-medium text-gray-700">Section Key <span class="text-red-500">*</span></label>
                        <input type="text" name="section_key" id="section_key" value="{{ old('section_key', $content->section_key) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                        @error('section_key')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="section_type" class="block text-sm font-medium text-gray-700">Section Type <span class="text-red-500">*</span></label>
                        <select name="section_type" id="section_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                            <option value="hero" {{ old('section_type', $content->section_type) === 'hero' ? 'selected' : '' }}>Hero</option>
                            <option value="content" {{ old('section_type', $content->section_type) === 'content' ? 'selected' : '' }}>Content</option>
                            <option value="video" {{ old('section_type', $content->section_type) === 'video' ? 'selected' : '' }}>Video</option>
                            <option value="info_block" {{ old('section_type', $content->section_type) === 'info_block' ? 'selected' : '' }}>Info Block</option>
                        </select>
                        @error('section_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $content->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea name="content" id="content" rows="10" class="quill-editor mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">{{ old('content', $content->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="data" class="block text-sm font-medium text-gray-700">Additional Data (JSON)</label>
                    <textarea name="data" id="data" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary font-mono text-sm">{{ old('data', is_array($content->data) ? json_encode($content->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : ($content->data ?? '{}')) }}</textarea>
                    @error('data')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $content->sort_order) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $content->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-za-green-primary focus:ring-za-green-primary">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Active
                        </label>
                    </div>
                </div>

                @if($content->hasMedia('images'))
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($content->getMedia('images') as $media)
                        <div class="relative">
                            <img src="{{ $media->getUrl('thumb') }}" alt="Image" class="h-24 w-full object-cover rounded-lg">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700">Add Images</label>
                    <input type="file" name="images[]" id="images" accept="image/*" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-za-green-primary file:text-white hover:file:bg-za-green-dark">
                    @error('images')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="bg-gray-50 border-t border-gray-200 shadow-lg rounded-lg p-6 mt-6 sticky bottom-0 z-10">
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('admin.homepage-contents.index') }}" class="px-4 py-2 border-2 border-gray-400 rounded-lg text-gray-800 bg-white hover:bg-gray-100 hover:border-gray-500 transition-colors font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors shadow-md hover:shadow-lg">
                    Update Content
                </button>
            </div>
        </div>
    </form>
</div>

@push('quill')
@include('admin.partials.quill')
@endpush
@endsection

