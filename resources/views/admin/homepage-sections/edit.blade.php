@extends('admin.layouts.app')

@section('title', 'Edit Homepage Section')
@section('page-title', 'Edit Homepage Section')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.homepage-sections.update', $section) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Section Information</h3>
            <div class="space-y-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="section_key" class="block text-sm font-medium text-gray-700">Section Key <span class="text-red-500">*</span></label>
                        <input type="text" name="section_key" id="section_key" value="{{ old('section_key', $section->section_key) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                        @error('section_key')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="section_type" class="block text-sm font-medium text-gray-700">Section Type <span class="text-red-500">*</span></label>
                        <select name="section_type" id="section_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                            <option value="hero" {{ old('section_type', $section->section_type) === 'hero' ? 'selected' : '' }}>Hero</option>
                            <option value="content" {{ old('section_type', $section->section_type) === 'content' ? 'selected' : '' }}>Content</option>
                            <option value="events" {{ old('section_type', $section->section_type) === 'events' ? 'selected' : '' }}>Events</option>
                            <option value="video" {{ old('section_type', $section->section_type) === 'video' ? 'selected' : '' }}>Video</option>
                            <option value="info_block" {{ old('section_type', $section->section_type) === 'info_block' ? 'selected' : '' }}>Info Block</option>
                            <option value="list" {{ old('section_type', $section->section_type) === 'list' ? 'selected' : '' }}>List</option>
                            <option value="advisors" {{ old('section_type', $section->section_type) === 'advisors' ? 'selected' : '' }}>Advisors</option>
                            <option value="board" {{ old('section_type', $section->section_type) === 'board' ? 'selected' : '' }}>Board</option>
                            <option value="achievements" {{ old('section_type', $section->section_type) === 'achievements' ? 'selected' : '' }}>Achievements</option>
                            <option value="stats" {{ old('section_type', $section->section_type) === 'stats' ? 'selected' : '' }}>Stats</option>
                            <option value="parallax" {{ old('section_type', $section->section_type) === 'parallax' ? 'selected' : '' }}>Parallax</option>
                            <option value="competitions" {{ old('section_type', $section->section_type) === 'competitions' ? 'selected' : '' }}>Competitions</option>
                            <option value="programs" {{ old('section_type', $section->section_type) === 'programs' ? 'selected' : '' }}>Programs</option>
                        </select>
                        @error('section_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

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
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea name="content" id="content" rows="10" class="quill-editor mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">{{ old('content', $section->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="button_text" class="block text-sm font-medium text-gray-700">Button Text</label>
                        <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $section->button_text) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                        @error('button_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="button_link" class="block text-sm font-medium text-gray-700">Button Link</label>
                        <input type="url" name="button_link" id="button_link" value="{{ old('button_link', $section->button_link) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                        @error('button_link')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="data" class="block text-sm font-medium text-gray-700">Additional Data (JSON)</label>
                    <textarea name="data" id="data" rows="8" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary font-mono text-sm">{{ old('data', is_array($section->data) ? json_encode($section->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : ($section->data ?? '{}')) }}</textarea>
                    @error('data')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $section->sort_order) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $section->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-za-green-primary focus:ring-za-green-primary">
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
                @if($section->hasMedia('images'))
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($section->getMedia('images') as $media)
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

                @if($section->hasMedia('background_image'))
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Background Image</label>
                    <img src="{{ $section->getFirstMediaUrl('background_image', 'medium') }}" alt="Background image" class="h-32 w-auto rounded-lg">
                </div>
                @endif
                <div>
                    <label for="background_image" class="block text-sm font-medium text-gray-700">Background Image</label>
                    <input type="file" name="background_image" id="background_image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-za-green-primary file:text-white hover:file:bg-za-green-dark">
                    @error('background_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if($section->hasMedia('video_poster'))
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Video Poster</label>
                    <img src="{{ $section->getFirstMediaUrl('video_poster', 'medium') }}" alt="Video poster" class="h-32 w-auto rounded-lg">
                </div>
                @endif
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
                    Update Section
                </button>
            </div>
        </div>
    </form>
</div>

@push('quill')
@include('admin.partials.quill')
@endpush
@endsection

