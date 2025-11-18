@extends('layouts.app')

@php
    $siteName = \App\Helpers\SiteHelper::getSiteName();
@endphp
@section('title', 'Contact Us - ' . $siteName)
@section('meta-description', 'Get in touch with ' . $siteName . '. Find our contact information, office hours, and send us a message')

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-8 sm:py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-6xl font-bold mb-4 sm:mb-6">Contact Us</h1>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl mb-6 sm:mb-8 max-w-3xl mx-auto px-4">
                    We'd love to hear from you. Reach out with questions about admissions, academics, or anything else
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="py-8 sm:py-12 md:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12">
                <!-- Contact Details -->
                <div class="order-2 lg:order-1">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6 sm:mb-8">Get In Touch</h2>

                    <div class="space-y-6">
                        <!-- Address -->
                        <div class="flex items-start">
                            <div class="bg-blue-100 rounded-full p-3 mr-4">
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Address</h3>
                                <p class="text-gray-600">
                                    {{ $siteName ?? \App\Helpers\SiteHelper::getSiteName() }}<br>
                                    Chattogram, Bangladesh
                                </p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start">
                            <div class="bg-green-100 rounded-full p-3 mr-4">
                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Phone</h3>
                                <p class="text-gray-600">
                                    <a href="tel:{{ str_replace([' ', '-'], '', config('contact.phone')) }}" class="hover:text-blue-600 transition duration-300">
                                        {{ config('contact.phone_display') }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start">
                            <div class="bg-yellow-100 rounded-full p-3 mr-4">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Email</h3>
                                <p class="text-gray-600">
                                    <a href="mailto:info@almaghribschool.com" class="hover:text-blue-600 transition duration-300">
                                        info@almaghribschool.com
                                    </a>
                                </p>
                                <p class="text-gray-600">
                                    <a href="mailto:career@almaghribschool.com" class="hover:text-blue-600 transition duration-300">
                                        career@almaghribschool.com
                                    </a>
                                </p>
                            </div>
                        </div>

                        <!-- Office Hours -->
                        <div class="flex items-start">
                            <div class="bg-purple-100 rounded-full p-3 mr-4">
                                <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Office Hours</h3>
                                <div class="text-gray-600">
                                    <p><strong>Sunday - Thursday:</strong> 9:00 AM - 3:00 PM</p>
                                    <p><strong>Friday - Saturday:</strong> Closed</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="mt-6 sm:mt-8">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Follow Us</h3>
                        <div class="flex flex-wrap gap-3 sm:gap-4">
                            <a href="https://facebook.com/almaghribschool" target="_blank" rel="noopener noreferrer"
                               class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full transition duration-300 min-w-[44px] min-h-[44px] flex items-center justify-center">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="order-1 lg:order-2">
                    <div class="bg-gray-50 rounded-lg p-4 sm:p-6 md:p-8">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">Send Us a Message</h2>

                        <form method="POST" action="{{ route('contact.send') }}" class="space-y-4 sm:space-y-6">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                                           class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-base @error('name') border-red-500 @enderror" required>
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                           class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-base @error('email') border-red-500 @enderror" required>
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                           class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-base @error('phone') border-red-500 @enderror">
                                    @error('phone')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject *</label>
                                    <select id="subject" name="subject"
                                            class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-base @error('subject') border-red-500 @enderror" required>
                                        <option value="">Select Subject</option>
                                        <option value="Admission Inquiry" {{ old('subject') == 'Admission Inquiry' ? 'selected' : '' }}>Admission Inquiry</option>
                                        <option value="Academic Information" {{ old('subject') == 'Academic Information' ? 'selected' : '' }}>Academic Information</option>
                                        <option value="Career Opportunity" {{ old('subject') == 'Career Opportunity' ? 'selected' : '' }}>Career Opportunity</option>
                                        <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                        <option value="Feedback" {{ old('subject') == 'Feedback' ? 'selected' : '' }}>Feedback</option>
                                        <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('subject')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
                                <textarea id="message" name="message" rows="6" class="w-full px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-base @error('message') border-red-500 @enderror"
                                          placeholder="Please enter your message here..." required>{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 sm:px-8 rounded-lg transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed min-h-[44px] w-full sm:w-auto">
                                    Send Message
                                </button>
                                <p class="text-xs sm:text-sm text-gray-600 mt-2 px-4">We typically respond within 24 hours during business days.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-8 sm:py-12 md:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-6 sm:mb-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3 sm:mb-4">Find Us</h2>
                <p class="text-base sm:text-lg text-gray-600 px-4">Visit our campus in Chattogram, Bangladesh</p>
            </div>

            <!-- Placeholder for Google Maps -->
            <div class="bg-gray-300 rounded-lg h-64 sm:h-80 md:h-96 flex items-center justify-center">
                <div class="text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <p class="text-gray-600">Interactive map will be embedded here</p>
                    <p class="text-sm text-gray-500 mt-2">{{ $siteName ?? \App\Helpers\SiteHelper::getSiteName() }}, Chattogram, Bangladesh</p>
                </div>
            </div>
        </div>
    </section>
@endsection