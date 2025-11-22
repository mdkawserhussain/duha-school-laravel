@extends('admin.layouts.app')

@section('title', 'Edit Hero Slide')
@section('page-title', 'Edit Hero Slide')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.hero-slider.update', $slide) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Slide Information</h3>
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $slideData['title']) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $slideData['subtitle']) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('subtitle')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" maxlength="500" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">{{ old('description', $slideData['description']) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="button_text" class="block text-sm font-medium text-gray-700">Button Text</label>
                        <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $slideData['button_text']) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                        @error('button_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="button_link" class="block text-sm font-medium text-gray-700">Button Link</label>
                        <input type="url" name="button_link" id="button_link" value="{{ old('button_link', $slideData['button_link']) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                        @error('button_link')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="badge" class="block text-sm font-medium text-gray-700">Badge</label>
                    <input type="text" name="badge" id="badge" value="{{ old('badge', $slideData['badge']) }}" placeholder="e.g., New, Featured" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('badge')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="video_url" class="block text-sm font-medium text-gray-700">Video URL</label>
                    <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $slideData['video_url']) }}" placeholder="https://example.com/video.mp4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('video_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $slideData['is_active']) ? 'checked' : '' }} class="rounded border-gray-300 text-za-green-primary focus:ring-za-green-primary">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        Active
                    </label>
                </div>
            </div>
        </div>

        <!-- Media -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Media</h3>
            <div class="space-y-6">
                @if($slideData['image_url'])
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Background Image</label>
                    <img src="{{ $slideData['image_url'] }}" alt="Background image" class="h-48 w-auto rounded-lg">
                </div>
                @endif
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Background Image</label>
                    <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-za-green-primary file:text-white hover:file:bg-za-green-dark">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if($slideData['video_poster'])
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Video Poster</label>
                    <img src="{{ $slideData['video_poster'] }}" alt="Video poster" class="h-48 w-auto rounded-lg">
                </div>
                @endif
                <div>
                    <label for="video_poster" class="block text-sm font-medium text-gray-700">Video Poster Image</label>
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
                <a href="{{ route('admin.hero-slider.index') }}" class="px-4 py-2 border-2 border-gray-400 rounded-lg text-gray-800 bg-white hover:bg-gray-100 hover:border-gray-500 transition-colors font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors shadow-md hover:shadow-lg">
                    Update Slide
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

