@extends('admin.layouts.app')

@section('title', 'Services Section')
@section('page-title', 'Services Section')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush

@section('content')
<div class="max-w-6xl">
    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @include('admin.partials.cache-clear-button')

    <form action="{{ route('admin.homepage.services.update') }}" method="POST" class="space-y-6" x-data="{ services: @js($services) }">
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
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="2" maxlength="500" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">{{ old('description', $section->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Services Repeater -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Services</h3>
                <button type="button" @click="services.push({ title: '', icon: '', bgColor: 'bg-blue-500', textColor: 'text-white', link: '#' })" class="px-4 py-2 bg-za-green-primary text-white text-sm font-semibold rounded-lg hover:bg-za-green-primary/90 transition-colors">
                    Add Service
                </button>
            </div>

            <div class="space-y-4" x-show="services.length > 0">
                <template x-for="(service, index) in services" :key="index">
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-medium text-gray-700" x-text="'Service ' + (index + 1)"></h4>
                            <button type="button" @click="services.splice(index, 1)" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                Remove
                            </button>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label :for="'service_title_' + index" class="block text-sm font-medium text-gray-700">Title <span class="text-red-500">*</span></label>
                                <input type="text" :name="'services[' + index + '][title]'" :id="'service_title_' + index" x-model="service.title" required maxlength="255" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                            </div>

                            <div>
                                <label :for="'service_link_' + index" class="block text-sm font-medium text-gray-700">Link <span class="text-red-500">*</span></label>
                                <input type="text" :name="'services[' + index + '][link]'" :id="'service_link_' + index" x-model="service.link" required maxlength="255" placeholder="/admission" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                            </div>

                            <div class="sm:col-span-2">
                                <label :for="'service_icon_' + index" class="block text-sm font-medium text-gray-700">Icon (SVG Path) <span class="text-red-500">*</span></label>
                                <textarea :name="'services[' + index + '][icon]'" :id="'service_icon_' + index" x-model="service.icon" required rows="2" maxlength="500" placeholder="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary font-mono text-sm"></textarea>
                                <p class="mt-1 text-xs text-gray-500">SVG path data from Heroicons or similar</p>
                            </div>

                            <div>
                                <label :for="'service_bgColor_' + index" class="block text-sm font-medium text-gray-700">Background Color <span class="text-red-500">*</span></label>
                                <select :name="'services[' + index + '][bgColor]'" :id="'service_bgColor_' + index" x-model="service.bgColor" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                                    <option value="bg-blue-500">Blue</option>
                                    <option value="bg-green-500">Green</option>
                                    <option value="bg-orange-500">Orange</option>
                                    <option value="bg-purple-600">Purple</option>
                                    <option value="bg-pink-500">Pink</option>
                                    <option value="bg-red-500">Red</option>
                                    <option value="bg-yellow-500">Yellow</option>
                                    <option value="bg-indigo-500">Indigo</option>
                                </select>
                            </div>

                            <div>
                                <label :for="'service_textColor_' + index" class="block text-sm font-medium text-gray-700">Text Color <span class="text-red-500">*</span></label>
                                <select :name="'services[' + index + '][textColor]'" :id="'service_textColor_' + index" x-model="service.textColor" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                                    <option value="text-white">White</option>
                                    <option value="text-black">Black</option>
                                    <option value="text-gray-900">Dark Gray</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div x-show="services.length === 0" class="text-center py-8 text-gray-500">
                <p>No services added yet. Click "Add Service" to get started.</p>
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

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 text-white font-semibold rounded-lg transition-colors shadow-md hover:shadow-lg" style="background-color: #008236;" onmouseover="this.style.backgroundColor='#0a4536'" onmouseout="this.style.backgroundColor='#008236'">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection

