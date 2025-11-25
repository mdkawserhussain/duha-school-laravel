@extends('layouts.app')

@php
    $siteName = \App\Helpers\SiteHelper::getSiteName();
@endphp
@section('title', 'Admissions - ' . $siteName)
@section('meta-description', 'Apply for admission to ' . $siteName . '. Join our Islamic and Cambridge curriculum program for grades K-12')

@push('scripts')
    @vite(['resources/js/scroll-animations.js'])
@endpush

@section('content')

    <!-- Page Hero Section -->
    <x-page-hero 
        title="Admission Going On"
        subtitle="Join our community of learners in the Islamic and Cambridge curriculum program for the 2025-26 academic year"
        badge="2025-26 Academic Year"
    />

    <!-- CTA Button Section -->
    <section class="py-6 sm:py-8" style="background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center fade-in">
            <a href="#admission-form" 
               class="inline-flex items-center justify-center rounded-xl px-8 py-4 text-base font-semibold text-white transition-all duration-200 hover:shadow-lg min-h-[44px]"
               style="background-color: #008236;"
               onmouseover="this.style.backgroundColor='#0a4536'"
               onmouseout="this.style.backgroundColor='#008236'">
                Apply Now
                <svg class="ml-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </section>

    <!-- Admission Information -->
    <section class="py-16 lg:py-24" style="background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 50%, #ffffff 100%);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16 fade-in">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold leading-tight mb-4 sm:mb-6" style="color: #008236; font-family: 'Playfair Display', serif;">Why Choose {{ $siteName }}?</h2>
                <p class="text-lg sm:text-xl text-gray-700 px-4 max-w-3xl mx-auto">A comprehensive Islamic education with Cambridge curriculum excellence</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-12 sm:mb-16">
                <div class="text-center bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 transform fade-in">
                    <div class="bg-green-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <svg class="h-10 w-10" style="color: #008236;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Islamic Education</h3>
                    <p class="text-gray-600 leading-relaxed">Comprehensive Islamic studies integrated with modern curriculum</p>
                </div>

                <div class="text-center bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 transform fade-in">
                    <div class="bg-green-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <svg class="h-10 w-10" style="color: #008236;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Cambridge Curriculum</h3>
                    <p class="text-gray-600 leading-relaxed">Internationally recognized curriculum for academic excellence</p>
                </div>

                <div class="text-center bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 transform fade-in">
                    <div class="bg-green-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <svg class="h-10 w-10" style="color: #008236;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Holistic Development</h3>
                    <p class="text-gray-600 leading-relaxed">Focus on character building, leadership, and community service</p>
                </div>
            </div>

            <!-- Admission Requirements -->
            <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 md:p-10 mb-12 sm:mb-16 fade-in">
                <h3 class="text-2xl sm:text-3xl font-serif font-bold mb-6 sm:mb-8" style="color: #008236; font-family: 'Playfair Display', serif;">Admission Requirements</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-12">
                    <div class="slide-left">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Documents Required</h4>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <svg class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" style="color: #008236;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Birth certificate</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" style="color: #008236;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Previous school records</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" style="color: #008236;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Medical certificate</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" style="color: #008236;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Passport-sized photographs</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" style="color: #008236;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Parent/Guardian ID</span>
                            </li>
                        </ul>
                    </div>
                    <div class="slide-right">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Eligibility Criteria</h4>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <svg class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" style="color: #008236;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Age appropriate for grade level</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" style="color: #008236;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Basic Islamic knowledge (for higher grades)</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" style="color: #008236;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Good conduct certificate</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" style="color: #008236;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Medical fitness</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Admission Form -->
    <section id="admission-form" class="py-16 lg:py-24" style="background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 md:p-10 fade-in">
                @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="text-center mb-8 sm:mb-10">
                    <h2 class="text-3xl sm:text-4xl font-serif font-bold mb-4 sm:mb-6" style="color: #008236; font-family: 'Playfair Display', serif;">Admission Application Form</h2>
                    <p class="text-base sm:text-lg text-gray-700 px-4">Please fill out all required fields. We will contact you within 3-5 business days.</p>
                </div>

                <form method="POST" action="{{ route('admission.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Parent Information -->
                    <div class="bg-green-50 p-6 rounded-xl mb-6 slide-left">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Parent/Guardian Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="parent_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                <input type="text" id="parent_name" name="parent_name" value="{{ old('parent_name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all @error('parent_name') border-red-500 @enderror" required>
                                @error('parent_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all @error('phone') border-red-500 @enderror" required>
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all @error('email') border-red-500 @enderror" required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Child Information -->
                    <div class="bg-green-50 p-6 rounded-xl mb-6 slide-right">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Child Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="child_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                <input type="text" id="child_name" name="child_name" value="{{ old('child_name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all @error('child_name') border-red-500 @enderror" required>
                                @error('child_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="child_dob" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth *</label>
                                <input type="date" id="child_dob" name="child_dob" value="{{ old('child_dob') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all @error('child_dob') border-red-500 @enderror" required>
                                @error('child_dob')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="grade_applied" class="block text-sm font-medium text-gray-700 mb-2">Grade Applied For *</label>
                            <select id="grade_applied" name="grade_applied"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all @error('grade_applied') border-red-500 @enderror" required>
                                <option value="">Select Grade</option>
                                <option value="Kindergarten" {{ old('grade_applied') == 'Kindergarten' ? 'selected' : '' }}>Kindergarten</option>
                                <option value="Grade 1" {{ old('grade_applied') == 'Grade 1' ? 'selected' : '' }}>Grade 1</option>
                                <option value="Grade 2" {{ old('grade_applied') == 'Grade 2' ? 'selected' : '' }}>Grade 2</option>
                                <option value="Grade 3" {{ old('grade_applied') == 'Grade 3' ? 'selected' : '' }}>Grade 3</option>
                                <option value="Grade 4" {{ old('grade_applied') == 'Grade 4' ? 'selected' : '' }}>Grade 4</option>
                                <option value="Grade 5" {{ old('grade_applied') == 'Grade 5' ? 'selected' : '' }}>Grade 5</option>
                                <option value="Grade 6" {{ old('grade_applied') == 'Grade 6' ? 'selected' : '' }}>Grade 6</option>
                                <option value="Grade 7" {{ old('grade_applied') == 'Grade 7' ? 'selected' : '' }}>Grade 7</option>
                                <option value="Grade 8" {{ old('grade_applied') == 'Grade 8' ? 'selected' : '' }}>Grade 8</option>
                                <option value="Grade 9" {{ old('grade_applied') == 'Grade 9' ? 'selected' : '' }}>Grade 9</option>
                                <option value="Grade 10" {{ old('grade_applied') == 'Grade 10' ? 'selected' : '' }}>Grade 10</option>
                                <option value="Grade 11" {{ old('grade_applied') == 'Grade 11' ? 'selected' : '' }}>Grade 11</option>
                                <option value="Grade 12" {{ old('grade_applied') == 'Grade 12' ? 'selected' : '' }}>Grade 12</option>
                            </select>
                            @error('grade_applied')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="mb-6 fade-in">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Additional Information</label>
                        <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all @error('message') border-red-500 @enderror"
                                  placeholder="Please provide any additional information about your child or special requirements...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Documents Upload -->
                    <div class="bg-yellow-50 p-6 rounded-xl mb-6 fade-in">
                        <h4 class="text-md font-semibold text-gray-900 mb-2">Supporting Documents (Optional)</h4>
                        <p class="text-sm text-gray-600 mb-4">You can upload supporting documents now or provide them later. Accepted formats: PDF, JPG, JPEG, PNG (Max 5MB each)</p>
                        <div>
                            <label for="documents" class="block text-sm font-medium text-gray-700 mb-2">Upload Documents</label>
                            <input type="file" id="documents" name="documents[]" multiple accept=".pdf,.jpg,.jpeg,.png"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all @error('documents.*') border-red-500 @enderror">
                            @error('documents.*')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center fade-in">
                        <button type="submit" 
                                class="inline-flex items-center justify-center rounded-xl px-8 py-4 text-base font-semibold text-white transition-all duration-200 hover:shadow-lg min-h-[44px] disabled:opacity-50 disabled:cursor-not-allowed"
                                style="background-color: #008236;"
                                onmouseover="this.style.backgroundColor='#0a4536'"
                                onmouseout="this.style.backgroundColor='#008236'">
                            Submit Application
                            <svg class="ml-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </button>
                        <p class="text-sm text-gray-600 mt-4">By submitting this form, you agree to our terms and conditions.</p>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection