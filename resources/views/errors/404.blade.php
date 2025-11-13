@extends('layouts.app')

@section('title', 'Page Not Found - Al-Maghrib International School')
@section('meta-description', 'The page you are looking for could not be found. Return to Al-Maghrib International School homepage')

@section('content')

    <!-- 404 Hero Section -->
    <section class="min-h-screen bg-gradient-to-r from-blue-600 to-blue-800 text-white flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <div class="mb-8">
                    <svg class="mx-auto h-32 w-32 text-white opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.203-2.47M12 7v14m0-14l-4 4m4-4l4 4"></path>
                    </svg>
                </div>

                <h1 class="text-6xl md:text-8xl font-bold mb-4">404</h1>
                <h2 class="text-2xl md:text-4xl font-bold mb-6">Page Not Found</h2>
                <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto opacity-90">
                    The page you're looking for seems to have wandered off our campus.
                    Don't worry, we'll help you find your way back!
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('home') }}" class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-4 px-8 rounded-lg transition duration-300 text-lg">
                        🏠 Go to Homepage
                    </a>
                    <button onclick="history.back()" class="bg-white bg-opacity-20 hover:bg-opacity-30 border border-white text-white font-semibold py-4 px-8 rounded-lg transition duration-300 text-lg">
                        ← Go Back
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Links Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Explore Our Website</h2>
                <p class="text-lg text-gray-600">Find what you're looking for from our main sections</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- About -->
                <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-lg transition duration-300">
                    <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">About Us</h3>
                    <p class="text-gray-600 mb-4">Learn about our mission, vision, and values</p>
                    <a href="{{ route('about.show', 'principal') }}" class="text-blue-600 hover:text-blue-800 font-medium transition duration-300">
                        Learn More →
                    </a>
                </div>

                <!-- Academics -->
                <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-lg transition duration-300">
                    <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Academics</h3>
                    <p class="text-gray-600 mb-4">Discover our curriculum and programs</p>
                    <a href="{{ route('academic.show', 'curriculum') }}" class="text-green-600 hover:text-green-800 font-medium transition duration-300">
                        Learn More →
                    </a>
                </div>

                <!-- Admission -->
                <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-lg transition duration-300">
                    <div class="bg-yellow-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Admission</h3>
                    <p class="text-gray-600 mb-4">Join our school community</p>
                    <a href="{{ route('admission.index') }}" class="text-yellow-600 hover:text-yellow-800 font-medium transition duration-300">
                        Apply Now →
                    </a>
                </div>

                <!-- Contact -->
                <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-lg transition duration-300">
                    <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Contact Us</h3>
                    <p class="text-gray-600 mb-4">Get in touch with our team</p>
                    <a href="{{ route('contact.index') }}" class="text-purple-600 hover:text-purple-800 font-medium transition duration-300">
                        Contact Us →
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Pages -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Popular Pages</h2>
                <p class="text-lg text-gray-600">Quick access to our most visited sections</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('events.index') }}" class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition duration-300">
                    <div class="flex items-center">
                        <div class="bg-blue-100 rounded-full p-3 mr-4">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">School Events</h3>
                            <p class="text-sm text-gray-600">Upcoming activities and celebrations</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('notices.index') }}" class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition duration-300">
                    <div class="flex items-center">
                        <div class="bg-green-100 rounded-full p-3 mr-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">School Notices</h3>
                            <p class="text-sm text-gray-600">Important announcements and updates</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('careers.index') }}" class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition duration-300">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 rounded-full p-3 mr-4">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0V8a2 2 0 01-2 2H8a2 2 0 01-2-2V6m8 0H8m0 0V4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Careers</h3>
                            <p class="text-sm text-gray-600">Join our teaching and administrative team</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('campus.show') }}" class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition duration-300">
                    <div class="flex items-center">
                        <div class="bg-purple-100 rounded-full p-3 mr-4">
                            <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Campus Facilities</h3>
                            <p class="text-sm text-gray-600">Explore our modern learning environment</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('contact.index') }}" class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition duration-300">
                    <div class="flex items-center">
                        <div class="bg-indigo-100 rounded-full p-3 mr-4">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Contact Information</h3>
                            <p class="text-sm text-gray-600">Phone, email, and office hours</p>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Can't Find What You're Looking For?</h2>
            <p class="text-xl mb-8 opacity-90">Try searching our website or contact us directly</p>

            <div class="max-w-md mx-auto mb-8">
                <div class="flex">
                    <input type="text" placeholder="Search our website..." class="flex-1 px-4 py-3 rounded-l-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-500" id="search-input">
                    <button class="bg-yellow-500 hover:bg-yellow-600 px-6 py-3 rounded-r-lg font-semibold transition duration-300" onclick="performSearch()">
                        Search
                    </button>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact.index') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 border border-white text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                    📞 Contact Support
                </a>
                <a href="tel:{{ str_replace([' ', '-'], '', config('contact.phone')) }}" class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-3 px-6 rounded-lg transition duration-300">
                    📞 Call Now
                </a>
            </div>
        </div>
    </section>

    <script>
        function performSearch() {
            const query = document.getElementById('search-input').value.trim();
            if (query) {
                // For now, redirect to home with search (can be enhanced with proper search functionality)
                window.location.href = '{{ route("home") }}' + '?search=' + encodeURIComponent(query);
            }
        }

        // Allow search on Enter key
        document.getElementById('search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    </script>

@endsection