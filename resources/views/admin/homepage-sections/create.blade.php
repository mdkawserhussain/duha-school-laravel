@extends('admin.layouts.app')

@section('title', 'Create Homepage Section')
@section('page-title', 'Create Homepage Section')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.homepage-sections.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ sectionKey: '', sectionType: 'content' }">
        @csrf

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Section Information</h3>
            <div class="space-y-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="section_key" class="block text-sm font-medium text-gray-700">Section Key <span class="text-red-500">*</span></label>
                        <input type="text" name="section_key" id="section_key" x-model="sectionKey" value="{{ old('section_key') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                        <p class="mt-1 text-xs text-gray-500">Unique identifier (e.g., hero, vision, intro)</p>
                        @error('section_key')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="section_type" class="block text-sm font-medium text-gray-700">Section Type <span class="text-red-500">*</span></label>
                        <select name="section_type" id="section_type" x-model="sectionType" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                            <option value="hero">Hero</option>
                            <option value="content">Content</option>
                            <option value="events">Events</option>
                            <option value="video">Video</option>
                            <option value="info_block">Info Block</option>
                            <option value="list">List</option>
                            <option value="advisors">Advisors</option>
                            <option value="board">Board</option>
                            <option value="achievements">Achievements</option>
                            <option value="stats">Stats</option>
                            <option value="parallax">Parallax</option>
                            <option value="competitions">Competitions</option>
                            <option value="programs">Programs</option>
                        </select>
                        @error('section_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('subtitle')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" maxlength="500" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea name="content" id="content" rows="10" class="quill-editor mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">{{ old('content') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Rich text editor will be integrated here (Phase 8)</p>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="button_text" class="block text-sm font-medium text-gray-700">Button Text</label>
                        <input type="text" name="button_text" id="button_text" value="{{ old('button_text') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                        @error('button_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="button_link" class="block text-sm font-medium text-gray-700">Button Link</label>
                        <input type="url" name="button_link" id="button_link" value="{{ old('button_link') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                        @error('button_link')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="data" class="block text-sm font-medium text-gray-700">Additional Data (JSON)</label>
                    <textarea name="data" id="data" rows="8" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary font-mono text-sm">{{ old('data', '{}') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">JSON format for structured content (e.g., {"values": ["Value 1", "Value 2"]})</p>
                    @error('data')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-za-green-primary focus:ring-za-green-primary">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Active
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Media -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Media</h3>
            <div class="space-y-6">
                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700">Images</label>
                    <input type="file" name="images[]" id="images" accept="image/*" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-za-green-primary file:text-white hover:file:bg-za-green-dark">
                    @error('images')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="background_image" class="block text-sm font-medium text-gray-700">Background Image</label>
                    <input type="file" name="background_image" id="background_image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-za-green-primary file:text-white hover:file:bg-za-green-dark">
                    @error('background_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="video_poster" class="block text-sm font-medium text-gray-700">Video Poster</label>
                    <input type="file" name="video_poster" id="video_poster" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-za-green-primary file:text-white hover:file:bg-za-green-dark">
                    @error('video_poster')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="bg-gray-50 border-t border-gray-200 shadow-lg rounded-lg p-6 mt-6 sticky bottom-0 z-10">
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('admin.homepage-sections.index') }}" class="px-4 py-2 border-2 border-gray-400 rounded-lg text-gray-800 bg-white hover:bg-gray-100 hover:border-gray-500 transition-colors font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors shadow-md hover:shadow-lg">
                    Create Section
                </button>
            </div>
        </div>
    </form>
</div>

@push('quill')
@include('admin.partials.quill')
@endpush
@endsection

