@extends('admin.layouts.app')

@section('title', 'Events Display Settings')
@section('page-title', 'Events Display Settings')

@section('content')
<div class="max-w-4xl">
    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @include('admin.partials.cache-clear-button')

    <form action="{{ route('admin.homepage.events.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Display Settings -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Display Settings</h3>
            <div class="space-y-6">
                <!-- Title Override -->
                <div>
                    <label for="title_override" class="block text-sm font-medium text-gray-700">Title Override</label>
                    <input type="text" name="title_override" id="title_override" value="{{ old('title_override', $settings['title_override']) }}" maxlength="255" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    <p class="mt-1 text-sm text-gray-500">Override the default section title. Leave empty to use default.</p>
                    @error('title_override')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Items Count -->
                <div>
                    <label for="items_count" class="block text-sm font-medium text-gray-700">Number of Events to Display <span class="text-red-500">*</span></label>
                    <input type="number" name="items_count" id="items_count" value="{{ old('items_count', $settings['items_count']) }}" min="1" max="20" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    <p class="mt-1 text-sm text-gray-500">Maximum number of events to show (1-20)</p>
                    @error('items_count')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Layout Style -->
                <div>
                    <label for="layout_style" class="block text-sm font-medium text-gray-700">Layout Style <span class="text-red-500">*</span></label>
                    <select name="layout_style" id="layout_style" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                        <option value="grid" {{ old('layout_style', $settings['layout_style']) === 'grid' ? 'selected' : '' }}>Grid</option>
                        <option value="list" {{ old('layout_style', $settings['layout_style']) === 'list' ? 'selected' : '' }}>List</option>
                        <option value="carousel" {{ old('layout_style', $settings['layout_style']) === 'carousel' ? 'selected' : '' }}>Carousel</option>
                    </select>
                    <p class="mt-1 text-sm text-gray-500">How events should be displayed on the homepage</p>
                    @error('layout_style')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Call to Action Button -->
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
                    <input type="text" name="button_link" id="button_link" value="{{ old('button_link', $section->button_link) }}" maxlength="255" placeholder="/events" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    <p class="mt-1 text-sm text-gray-500">URL path (e.g., /events)</p>
                    @error('button_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
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
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $section->is_active) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-za-green-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-za-green-primary"></div>
                </label>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-medium text-blue-900 mb-3">Quick Links</h3>
            <p class="text-sm text-blue-700 mb-4">Manage the events that appear in this section:</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.events.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Manage Events
                </a>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 text-white font-semibold rounded-lg transition-colors shadow-md hover:shadow-lg" style="background-color: #008236;" onmouseover="this.style.backgroundColor='#0a4536'" onmouseout="this.style.backgroundColor='#008236'">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection

