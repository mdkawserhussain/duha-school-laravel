@extends('layouts.app')

@section('title', 'Server Error - Al-Maghrib International School')
@section('meta-description', 'We encountered an error processing your request. Please try again or contact us for assistance.')

@section('content')

    <!-- 500 Hero Section -->
    <section class="min-h-screen bg-gradient-to-r from-red-600 to-red-800 text-white flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <div class="mb-8">
                    <svg class="mx-auto h-32 w-32 text-white opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>

                <h1 class="text-6xl md:text-8xl font-bold mb-4">500</h1>
                <h2 class="text-2xl md:text-4xl font-bold mb-6">Server Error</h2>
                <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto opacity-90">
                    Oops! Something went wrong on our end. We're working to fix this issue.
                    Please try again in a few moments.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('home') }}" class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-4 px-8 rounded-lg transition duration-300 text-lg">
                        🏠 Go to Homepage
                    </a>
                    <button onclick="location.reload()" class="bg-white bg-opacity-20 hover:bg-opacity-30 border border-white text-white font-semibold py-4 px-8 rounded-lg transition duration-300 text-lg">
                        🔄 Try Again
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Help Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Need Immediate Assistance?</h2>
                <p class="text-lg text-gray-600">Our team is here to help you</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Phone -->
                <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-lg transition duration-300">
                    <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Call Us</h3>
                    <p class="text-gray-600 mb-4">Speak with our team directly</p>
                    <a href="tel:{{ str_replace([' ', '-'], '', config('contact.phone')) }}" class="text-blue-600 hover:text-blue-800 font-medium transition duration-300">
                        {{ config('contact.phone_display') }}
                    </a>
                </div>

                <!-- Email -->
                <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-lg transition duration-300">
                    <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Email Us</h3>
                    <p class="text-gray-600 mb-4">Send us a message</p>
                    <a href="mailto:{{ config('contact.email.info') }}" class="text-green-600 hover:text-green-800 font-medium transition duration-300">
                        {{ config('contact.email.info') }}
                    </a>
                </div>

                <!-- Contact Form -->
                <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-lg transition duration-300">
                    <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Contact Form</h3>
                    <p class="text-gray-600 mb-4">Fill out our contact form</p>
                    <a href="{{ route('contact.index') }}" class="text-purple-600 hover:text-purple-800 font-medium transition duration-300">
                        Contact Us →
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Office Hours -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Office Hours</h2>
            <p class="text-lg text-gray-600 mb-8">{{ config('contact.office_hours.weekdays') }}</p>
            <p class="text-md text-gray-500">{{ config('contact.office_hours.weekend') }}</p>
        </div>
    </section>

    <!-- Quick Links -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Quick Links</h2>
                <p class="text-lg text-gray-600">Navigate to other sections of our website</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <a href="{{ route('home') }}" class="text-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                    <div class="text-2xl mb-2">🏠</div>
                    <div class="font-semibold text-gray-900">Home</div>
                </a>
                <a href="{{ route('about.show', 'principal') }}" class="text-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                    <div class="text-2xl mb-2">ℹ️</div>
                    <div class="font-semibold text-gray-900">About</div>
                </a>
                <a href="{{ route('academic.show', 'curriculum') }}" class="text-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                    <div class="text-2xl mb-2">📚</div>
                    <div class="font-semibold text-gray-900">Academics</div>
                </a>
                <a href="{{ route('admission.index') }}" class="text-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                    <div class="text-2xl mb-2">✍️</div>
                    <div class="font-semibold text-gray-900">Admission</div>
                </a>
                <a href="{{ route('events.index') }}" class="text-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                    <div class="text-2xl mb-2">📅</div>
                    <div class="font-semibold text-gray-900">Events</div>
                </a>
                <a href="{{ route('notices.index') }}" class="text-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                    <div class="text-2xl mb-2">📢</div>
                    <div class="font-semibold text-gray-900">Notices</div>
                </a>
                <a href="{{ route('careers.index') }}" class="text-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                    <div class="text-2xl mb-2">💼</div>
                    <div class="font-semibold text-gray-900">Careers</div>
                </a>
                <a href="{{ route('contact.index') }}" class="text-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                    <div class="text-2xl mb-2">📞</div>
                    <div class="font-semibold text-gray-900">Contact</div>
                </a>
            </div>
        </div>
    </section>

@endsection

