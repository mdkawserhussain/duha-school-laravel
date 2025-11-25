@extends('admin.layouts.app')

@section('title', 'Testimonials Section')
@section('page-title', 'Testimonials Section')

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

    <form action="{{ route('admin.homepage.testimonials.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ testimonials: @js($testimonials) }">
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

        <!-- Testimonials Repeater -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Testimonials</h3>
                <button type="button" @click="testimonials.push({ quote: '', author: '', role: '', student: '', avatar: null })" class="px-4 py-2 bg-za-green-primary text-white text-sm font-semibold rounded-lg hover:bg-za-green-primary/90 transition-colors">
                    Add Testimonial
                </button>
            </div>

            <div class="space-y-4" x-show="testimonials.length > 0">
                <template x-for="(testimonial, index) in testimonials" :key="index">
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-medium text-gray-700" x-text="'Testimonial ' + (index + 1)"></h4>
                            <button type="button" @click="testimonials.splice(index, 1)" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                Remove
                            </button>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label :for="'testimonial_quote_' + index" class="block text-sm font-medium text-gray-700">Quote <span class="text-red-500">*</span></label>
                                <textarea :name="'testimonials[' + index + '][quote]'" :id="'testimonial_quote_' + index" x-model="testimonial.quote" required rows="3" maxlength="1000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary"></textarea>
                            </div>

                            <div>
                                <label :for="'testimonial_author_' + index" class="block text-sm font-medium text-gray-700">Author <span class="text-red-500">*</span></label>
                                <input type="text" :name="'testimonials[' + index + '][author]'" :id="'testimonial_author_' + index" x-model="testimonial.author" required maxlength="255" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                            </div>

                            <div>
                                <label :for="'testimonial_role_' + index" class="block text-sm font-medium text-gray-700">Role</label>
                                <input type="text" :name="'testimonials[' + index + '][role]'" :id="'testimonial_role_' + index" x-model="testimonial.role" maxlength="255" placeholder="Parent" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                            </div>

                            <div>
                                <label :for="'testimonial_student_' + index" class="block text-sm font-medium text-gray-700">Student Name</label>
                                <input type="text" :name="'testimonials[' + index + '][student]'" :id="'testimonial_student_' + index" x-model="testimonial.student" maxlength="255" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                            </div>

                            <div>
                                <label :for="'testimonial_avatar_' + index" class="block text-sm font-medium text-gray-700">Avatar Image</label>
                                <input type="file" :name="'testimonials[' + index + '][avatar]'" :id="'testimonial_avatar_' + index" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-za-green-primary file:text-white hover:file:bg-za-green-dark">
                                <p class="mt-1 text-xs text-gray-500">Optional: Upload an avatar image</p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div x-show="testimonials.length === 0" class="text-center py-8 text-gray-500">
                <p>No testimonials added yet. Click "Add Testimonial" to get started.</p>
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

