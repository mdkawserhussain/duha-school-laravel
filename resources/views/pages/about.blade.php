@extends('layouts.app')

@section('title', 'About Us - Al-Maghrib International School')
@section('meta-description', 'Learn about Al-Maghrib International School\'s mission, vision, and commitment to Islamic and Cambridge curriculum education in Chattogram, Bangladesh')

@section('content')

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">About Al-Maghrib</h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                    Nurturing young minds with Islamic values and Cambridge curriculum excellence
                </p>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Mission -->
                <div class="bg-blue-50 p-8 rounded-lg">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-100 rounded-full p-3 mr-4">
                            <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">Our Mission</h2>
                    </div>
                    <p class="text-gray-700 text-lg leading-relaxed">
                        To provide comprehensive Islamic and Cambridge curriculum education that nurtures academic excellence,
                        moral character, and spiritual growth in a supportive and inclusive environment.
                    </p>
                </div>

                <!-- Vision -->
                <div class="bg-green-50 p-8 rounded-lg">
                    <div class="flex items-center mb-6">
                        <div class="bg-green-100 rounded-full p-3 mr-4">
                            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900">Our Vision</h2>
                    </div>
                    <p class="text-gray-700 text-lg leading-relaxed">
                        To be a leading Islamic international school that produces well-rounded individuals who excel
                        academically, embody Islamic values, and contribute positively to society.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Core Values</h2>
                <p class="text-lg text-gray-600">The principles that guide everything we do</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-yellow-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Excellence</h3>
                    <p class="text-gray-600">Striving for the highest standards in education and character development</p>
                </div>

                <div class="text-center">
                    <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Compassion</h3>
                    <p class="text-gray-600">Fostering kindness, empathy, and care for others in our community</p>
                </div>

                <div class="text-center">
                    <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Integrity</h3>
                    <p class="text-gray-600">Building trust through honesty, responsibility, and ethical behavior</p>
                </div>

                <div class="text-center">
                    <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Community</h3>
                    <p class="text-gray-600">Building strong relationships and supporting one another</p>
                </div>
            </div>
        </div>
    </section>

    <!-- History & Background -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
                    <div class="space-y-4 text-gray-700">
                        <p>
                            Founded in 2025, Al-Maghrib International School emerged from a vision to create an educational
                            institution that seamlessly integrates Islamic teachings with world-class academic standards.
                        </p>
                        <p>
                            Located in the heart of Chattogram, Bangladesh, our school serves as a beacon of educational
                            excellence, welcoming students from diverse backgrounds who share our commitment to holistic development.
                        </p>
                        <p>
                            Through our Cambridge curriculum and Islamic studies program, we prepare students not just for
                            academic success, but for a lifetime of meaningful contribution to their communities and society.
                        </p>
                    </div>
                </div>
                <div class="bg-gray-100 rounded-lg p-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Key Milestones</h3>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <div class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3 flex-shrink-0">2025</div>
                            <div>
                                <p class="font-medium text-gray-900">School Founded</p>
                                <p class="text-sm text-gray-600">Al-Maghrib International School opens its doors</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-green-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3 flex-shrink-0">2025</div>
                            <div>
                                <p class="font-medium text-gray-900">Cambridge Accreditation</p>
                                <p class="text-sm text-gray-600">Official Cambridge International curriculum implementation</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-yellow-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3 flex-shrink-0">2026</div>
                            <div>
                                <p class="font-medium text-gray-900">First Graduates</p>
                                <p class="text-sm text-gray-600">Celebrating our pioneering class of graduates</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Leadership</h2>
                <p class="text-lg text-gray-600">Meet the dedicated professionals guiding our school</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Principal -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="w-24 h-24 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Principal Name</h3>
                    <p class="text-blue-600 font-medium mb-3">Principal</p>
                    <p class="text-gray-600 text-sm">
                        Leading our school with vision and dedication to provide exceptional Islamic education.
                    </p>
                </div>

                <!-- Vice Principal -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="w-24 h-24 bg-gradient-to-r from-green-500 to-green-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Vice Principal Name</h3>
                    <p class="text-green-600 font-medium mb-3">Vice Principal</p>
                    <p class="text-gray-600 text-sm">
                        Supporting academic excellence and ensuring smooth school operations.
                    </p>
                </div>

                <!-- Head of Islamic Studies -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="w-24 h-24 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Islamic Studies Head</h3>
                    <p class="text-yellow-600 font-medium mb-3">Head of Islamic Studies</p>
                    <p class="text-gray-600 text-sm">
                        Guiding students in Islamic knowledge and spiritual development.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Join Our Community</h2>
            <p class="text-xl mb-8">Be part of our mission to provide exceptional Islamic education</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('admission.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-3 px-8 rounded-lg transition duration-300">
                    Apply for Admission
                </a>
                <a href="{{ route('contact.index') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 border border-white text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

@endsection