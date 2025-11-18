@extends('layouts.app')

@php
    $siteName = \App\Helpers\SiteHelper::getSiteName();
@endphp
@section('title', 'Admissions - ' . $siteName)
@section('meta-description', 'Apply for admission to ' . $siteName . '. Join our Islamic and Cambridge curriculum program for grades K-12')

@section('content')

    <!-- Page Hero Section -->
    <x-page-hero 
        title="Admission Going On"
        subtitle="Join our community of learners in the Islamic and Cambridge curriculum program for the 2025-26 academic year"
        badge="2025-26 Academic Year"
    />

    <!-- CTA Button Section -->
    <section class="py-6 sm:py-8 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <a href="#admission-form" class="inline-flex items-center justify-center rounded-xl border-2 border-aisd-gold bg-aisd-gold px-8 py-4 text-base font-semibold text-aisd-midnight transition-all hover:bg-aisd-gold/90 hover:border-aisd-gold/90 min-h-[44px] shadow-modern">
                Apply Now
                <svg class="ml-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </section>

    <!-- Admission Information -->
    <section class="py-12 sm:py-16 md:py-20 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-aisd-midnight mb-4 sm:mb-6" style="font-family: 'Playfair Display', serif;">Why Choose {{ $siteName }}?</h2>
                <p class="text-lg sm:text-xl text-gray-700 px-4 max-w-3xl mx-auto">A comprehensive Islamic education with Cambridge curriculum excellence</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-12 sm:mb-16">
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Islamic Education</h3>
                    <p class="text-gray-600">Comprehensive Islamic studies integrated with modern curriculum</p>
                </div>

                <div class="text-center">
                    <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Cambridge Curriculum</h3>
                    <p class="text-gray-600">Internationally recognized curriculum for academic excellence</p>
                </div>

                <div class="text-center">
                    <div class="bg-yellow-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Holistic Development</h3>
                    <p class="text-gray-600">Focus on character building, leadership, and community service</p>
                </div>
            </div>

            <!-- Admission Requirements -->
            <div class="bg-gray-50 rounded-lg p-4 sm:p-6 md:p-8 mb-12 sm:mb-16">
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">Admission Requirements</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-3">Documents Required</h4>
                        <ul class="space-y-2 text-gray-600">
                            <li>• Birth certificate</li>
                            <li>• Previous school records</li>
                            <li>• Medical certificate</li>
                            <li>• Passport-sized photographs</li>
                            <li>• Parent/Guardian ID</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-3">Eligibility Criteria</h4>
                        <ul class="space-y-2 text-gray-600">
                            <li>• Age appropriate for grade level</li>
                            <li>• Basic Islamic knowledge (for higher grades)</li>
                            <li>• Good conduct certificate</li>
                            <li>• Medical fitness</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Admission Form -->
    <section id="admission-form" class="py-12 sm:py-16 md:py-20 lg:py-24 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-modern p-6 sm:p-8 md:p-10">
                <div class="text-center mb-8 sm:mb-10">
                    <h2 class="text-3xl sm:text-4xl font-bold text-aisd-midnight mb-4 sm:mb-6" style="font-family: 'Playfair Display', serif;">Admission Application Form</h2>
                    <p class="text-base sm:text-lg text-gray-700 px-4">Please fill out all required fields. We will contact you within 3-5 business days.</p>
                </div>

                <form method="POST" action="{{ route('admission.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Parent Information -->
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Parent/Guardian Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="parent_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                <input type="text" id="parent_name" name="parent_name" value="{{ old('parent_name') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('parent_name') border-red-500 @enderror" required>
                                @error('parent_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror" required>
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Child Information -->
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Child Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="child_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                <input type="text" id="child_name" name="child_name" value="{{ old('child_name') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('child_name') border-red-500 @enderror" required>
                                @error('child_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="child_dob" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth *</label>
                                <input type="date" id="child_dob" name="child_dob" value="{{ old('child_dob') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('child_dob') border-red-500 @enderror" required>
                                @error('child_dob')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="grade_applied" class="block text-sm font-medium text-gray-700 mb-1">Grade Applied For *</label>
                            <select id="grade_applied" name="grade_applied"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('grade_applied') border-red-500 @enderror" required>
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
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Additional Information</label>
                        <textarea id="message" name="message" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('message') border-red-500 @enderror"
                                  placeholder="Please provide any additional information about your child or special requirements...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Documents Upload -->
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <h4 class="text-md font-semibold text-gray-900 mb-2">Supporting Documents (Optional)</h4>
                        <p class="text-sm text-gray-600 mb-3">You can upload supporting documents now or provide them later. Accepted formats: PDF, JPG, JPEG, PNG (Max 5MB each)</p>
                        <div>
                            <label for="documents" class="block text-sm font-medium text-gray-700 mb-1">Upload Documents</label>
                            <input type="file" id="documents" name="documents[]" multiple accept=".pdf,.jpg,.jpeg,.png"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('documents.*') border-red-500 @enderror">
                            @error('documents.*')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl border-2 border-aisd-ocean bg-aisd-ocean px-8 py-4 text-base font-semibold text-white transition-all hover:bg-aisd-cobalt hover:border-aisd-cobalt min-h-[44px] shadow-modern disabled:opacity-50 disabled:cursor-not-allowed">
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