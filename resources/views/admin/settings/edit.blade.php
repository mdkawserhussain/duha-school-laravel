@extends('admin.layouts.app')

@section('title', 'Site Settings')
@section('page-title', 'Site Settings')

@section('content')
<div class="max-w-6xl">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- General Settings -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">General Settings</h3>
            <div class="space-y-6">
                <div>
                    <label for="website_name" class="block text-sm font-medium text-gray-700">Website Name <span class="text-red-500">*</span></label>
                    <input type="text" name="website_name" id="website_name" value="{{ old('website_name', $settings->website_name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('website_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="website_tagline" class="block text-sm font-medium text-gray-700">Website Tagline</label>
                    <input type="text" name="website_tagline" id="website_tagline" value="{{ old('website_tagline', $settings->website_tagline) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('website_tagline')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="website_description" class="block text-sm font-medium text-gray-700">Website Description</label>
                    <textarea name="website_description" id="website_description" rows="3" maxlength="1000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">{{ old('website_description', $settings->website_description) }}</textarea>
                    @error('website_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="primary_email" class="block text-sm font-medium text-gray-700">Primary Email</label>
                    <input type="email" name="primary_email" id="primary_email" value="{{ old('primary_email', $settings->primary_email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('primary_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="primary_phone" class="block text-sm font-medium text-gray-700">Primary Phone</label>
                    <input type="text" name="primary_phone" id="primary_phone" value="{{ old('primary_phone', $settings->primary_phone) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('primary_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="physical_address" class="block text-sm font-medium text-gray-700">Physical Address</label>
                    <textarea name="physical_address" id="physical_address" rows="2" maxlength="500" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">{{ old('physical_address', $settings->physical_address) }}</textarea>
                    @error('physical_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Social Media Links</h3>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="social_media_links_facebook" class="block text-sm font-medium text-gray-700">Facebook</label>
                    <input type="url" name="social_media_links[facebook]" id="social_media_links_facebook" value="{{ old('social_media_links.facebook', $settings->social_media_links['facebook'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                </div>

                <div>
                    <label for="social_media_links_twitter" class="block text-sm font-medium text-gray-700">Twitter/X</label>
                    <input type="url" name="social_media_links[twitter]" id="social_media_links_twitter" value="{{ old('social_media_links.twitter', $settings->social_media_links['twitter'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                </div>

                <div>
                    <label for="social_media_links_instagram" class="block text-sm font-medium text-gray-700">Instagram</label>
                    <input type="url" name="social_media_links[instagram]" id="social_media_links_instagram" value="{{ old('social_media_links.instagram', $settings->social_media_links['instagram'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                </div>

                <div>
                    <label for="social_media_links_youtube" class="block text-sm font-medium text-gray-700">YouTube</label>
                    <input type="url" name="social_media_links[youtube]" id="social_media_links_youtube" value="{{ old('social_media_links.youtube', $settings->social_media_links['youtube'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                </div>
            </div>
        </div>

        <!-- Branding -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Branding</h3>
            <div class="space-y-6">
                @if($settings->hasMedia('logo'))
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Logo</label>
                    <img src="{{ $settings->getFirstMediaUrl('logo', 'medium') }}" alt="Logo" class="h-32 w-auto">
                </div>
                @endif
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
                    <input type="file" name="logo" id="logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-za-green-primary file:text-white hover:file:bg-za-green-dark">
                    @error('logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if($settings->hasMedia('favicon'))
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Favicon</label>
                    <img src="{{ $settings->getFirstMediaUrl('favicon', 'thumb') }}" alt="Favicon" class="h-16 w-16">
                </div>
                @endif
                <div>
                    <label for="favicon" class="block text-sm font-medium text-gray-700">Favicon</label>
                    <input type="file" name="favicon" id="favicon" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-za-green-primary file:text-white hover:file:bg-za-green-dark">
                    @error('favicon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Theme Colors -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Theme Colors</h3>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                <div>
                    <label for="primary_color" class="block text-sm font-medium text-gray-700">Primary Color</label>
                    <input type="color" name="primary_color" id="primary_color" value="{{ old('primary_color', $settings->primary_color ?? '#0F4C81') }}" class="mt-1 block w-full h-10 rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('primary_color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="secondary_color" class="block text-sm font-medium text-gray-700">Secondary Color</label>
                    <input type="color" name="secondary_color" id="secondary_color" value="{{ old('secondary_color', $settings->secondary_color ?? '#1E3A8A') }}" class="mt-1 block w-full h-10 rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('secondary_color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="accent_color" class="block text-sm font-medium text-gray-700">Accent Color</label>
                    <input type="color" name="accent_color" id="accent_color" value="{{ old('accent_color', $settings->accent_color ?? '#F4C430') }}" class="mt-1 block w-full h-10 rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                    @error('accent_color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="bg-gray-50 border-t border-gray-200 shadow-lg rounded-lg p-6 mt-6 sticky bottom-0 z-10">
            <div class="flex items-center justify-end">
                <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors shadow-md hover:shadow-lg">
                    Save Settings
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

