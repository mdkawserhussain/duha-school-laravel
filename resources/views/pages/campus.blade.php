@extends('layouts.app')

@php
    $siteName = \App\Helpers\SiteHelper::getSiteName();
@endphp
@section('title', 'Campus - ' . $siteName)
@section('meta-description', 'Explore our modern campus facilities at ' . $siteName . ' in Chattogram, Bangladesh. State-of-the-art classrooms, labs, and recreational areas')

@section('content')

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-purple-600 to-purple-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Our Campus</h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                    A modern learning environment designed for academic excellence and spiritual growth
                </p>
            </div>
        </div>
    </section>

    <!-- Campus Overview -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Modern Facilities for Modern Learning</h2>
                    <div class="space-y-4 text-gray-700">
                        <p>
                            Our campus in Chattogram spans over 50,000 square feet and features state-of-the-art
                            facilities designed to support comprehensive Islamic and Cambridge curriculum education.
                        </p>
                        <p>
                            From well-equipped science laboratories to dedicated prayer spaces, every aspect of our
                            campus is thoughtfully designed to nurture both academic achievement and spiritual development.
                        </p>
                        <p>
                            Located in a serene environment conducive to learning, our campus provides a safe and
                            inspiring atmosphere for students from Kindergarten to Grade 12.
                        </p>
                    </div>
                </div>
                <div class="bg-gray-100 rounded-lg p-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Campus Highlights</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600 mb-1">50,000+</div>
                            <div class="text-sm text-gray-600">Square Feet</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600 mb-1">25+</div>
                            <div class="text-sm text-gray-600">Classrooms</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600 mb-1">8</div>
                            <div class="text-sm text-gray-600">Labs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600 mb-1">2</div>
                            <div class="text-sm text-gray-600">Prayer Halls</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Facilities Grid -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Campus Facilities</h2>
                <p class="text-lg text-gray-600">World-class amenities for comprehensive education</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Academic Facilities -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-48 bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Smart Classrooms</h3>
                        <p class="text-gray-600 mb-4">
                            Modern classrooms equipped with interactive whiteboards, projectors, and audio-visual systems
                            for enhanced learning experiences.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Interactive whiteboards</li>
                            <li>• Audio-visual equipment</li>
                            <li>• Wi-Fi connectivity</li>
                            <li>• Comfortable seating</li>
                        </ul>
                    </div>
                </div>

                <!-- Science Labs -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-48 bg-gradient-to-r from-green-500 to-green-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Science Laboratories</h3>
                        <p class="text-gray-600 mb-4">
                            Fully equipped physics, chemistry, and biology labs with modern apparatus and safety features.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Physics laboratory</li>
                            <li>• Chemistry laboratory</li>
                            <li>• Biology laboratory</li>
                            <li>• Computer lab</li>
                        </ul>
                    </div>
                </div>

                <!-- Library -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-48 bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Modern Library</h3>
                        <p class="text-gray-600 mb-4">
                            A comprehensive library with Islamic texts, academic books, digital resources, and study areas.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• 10,000+ books collection</li>
                            <li>• Islamic manuscripts</li>
                            <li>• Digital catalog system</li>
                            <li>• Reading areas</li>
                        </ul>
                    </div>
                </div>

                <!-- Prayer Facilities -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-48 bg-gradient-to-r from-indigo-500 to-indigo-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Prayer Facilities</h3>
                        <p class="text-gray-600 mb-4">
                            Dedicated prayer halls for boys and girls, wudu areas, and Islamic learning spaces.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Separate prayer halls</li>
                            <li>• Wudu facilities</li>
                            <li>• Islamic calligraphy displays</li>
                            <li>• Quiet reflection areas</li>
                        </ul>
                    </div>
                </div>

                <!-- Sports Facilities -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-48 bg-gradient-to-r from-red-500 to-red-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Sports & Recreation</h3>
                        <p class="text-gray-600 mb-4">
                            Basketball court, football field, and indoor sports facilities for physical development.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Basketball court</li>
                            <li>• Football field</li>
                            <li>• Indoor gym</li>
                            <li>• Fitness equipment</li>
                        </ul>
                    </div>
                </div>

                <!-- Cafeteria -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-48 bg-gradient-to-r from-orange-500 to-orange-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Cafeteria</h3>
                        <p class="text-gray-600 mb-4">
                            Clean and hygienic cafeteria serving nutritious halal meals and snacks for students.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Halal certified meals</li>
                            <li>• Nutritious menu</li>
                            <li>• Clean dining areas</li>
                            <li>• Dietary accommodations</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location & Transportation -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Location & Transportation</h2>
                <p class="text-lg text-gray-600">Conveniently located in Chattogram with easy access</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Location Info -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Our Location</h3>
                    <div class="bg-gray-50 p-6 rounded-lg mb-6">
                        <div class="flex items-start mb-4">
                            <svg class="h-6 w-6 text-gray-600 mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900">{{ $siteName }}</p>
                                <p class="text-gray-600">Chattogram, Bangladesh</p>
                            </div>
                        </div>
                        <p class="text-gray-600">
                            Located in a peaceful residential area of Chattogram, our campus provides a serene
                            environment ideal for focused learning and spiritual reflection.
                        </p>
                    </div>

                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Transportation Options</h4>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <div class="bg-blue-100 rounded-full p-2 mr-3">
                                <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">School Bus Service</p>
                                <p class="text-sm text-gray-600">Available routes covering major areas of Chattogram</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-green-100 rounded-full p-2 mr-3">
                                <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Public Transport</p>
                                <p class="text-sm text-gray-600">Easy access via local buses and rickshaws</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-yellow-100 rounded-full p-2 mr-3">
                                <svg class="h-4 w-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Parking Facilities</p>
                                <p class="text-sm text-gray-600">Dedicated parking for parents and visitors</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Placeholder -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Find Us</h3>
                    <div class="bg-gray-200 rounded-lg h-96 flex items-center justify-center mb-6">
                        <div class="text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            <p class="text-gray-600 font-medium">Interactive Campus Map</p>
                            <p class="text-sm text-gray-500 mt-2">Detailed map and directions will be embedded here</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('contact.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                            Get Directions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Virtual Tour -->
    <section class="py-16 bg-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Take a Virtual Tour</h2>
            <p class="text-xl mb-8">Experience our campus from the comfort of your home</p>
            <div class="bg-white bg-opacity-10 rounded-lg p-8 max-w-2xl mx-auto">
                <svg class="mx-auto h-24 w-24 text-white mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l4 4m0 0l4-4m-4 4V6"></path>
                </svg>
                <p class="text-lg mb-6">Our virtual tour will be available soon, showcasing all our campus facilities and learning spaces.</p>
                <button class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-3 px-8 rounded-lg transition duration-300">
                    Notify Me When Available
                </button>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Visit Our Campus</h2>
            <p class="text-xl text-gray-600 mb-8">Schedule a campus tour and see our facilities in person</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('admission.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                    Apply for Admission
                </a>
                <a href="{{ route('contact.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                    Schedule a Tour
                </a>
            </div>
        </div>
    </section>

@endsection