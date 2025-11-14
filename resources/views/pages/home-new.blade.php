@extends('layouts.app')

@section('title', 'Welcome to Al-Maghrib International School')
@section('meta-description', 'Islamic and Cambridge curriculum school providing quality education in Chattogram, Bangladesh')

@push('scripts')
    <x-organization-structured-data />
    @vite(['resources/js/homepage.js'])
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative bg-white overflow-hidden">
    <div class="absolute inset-0 bg-linear-to-r from-blue-900 via-blue-800 to-blue-700"></div>
    <div class="absolute inset-0" style="background-image: url('{{ asset('images/school-pattern.jpg') }}'); background-size: cover; background-position: center; opacity: 0.1;"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="lg:grid lg:grid-cols-2 lg:gap-12 lg:items-center">
            <div class="mb-12 lg:mb-0">
                <div class="mb-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Excellence in Islamic Education
                    </span>
                </div>
                <h1 class="text-4xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                    Inspire <span class="text-yellow-400">Lifelong</span><br>
                    Learning
                </h1>
                <p class="text-xl text-blue-100 mb-8 max-w-lg">
                    A carefully balanced Cambridge and Islamic curriculum delivered by passionate educators across modern campuses.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#about" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-blue-900 bg-yellow-400 hover:bg-yellow-300 transition-colors">
                        Learn More
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#admissions" class="inline-flex items-center px-6 py-3 border border-white/30 text-base font-medium rounded-lg text-white hover:bg-white/10 transition-colors">
                        Apply Now
                    </a>
                </div>
            </div>
            
            <!-- Hero Stats -->
            <div class="lg:justify-self-end">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-white mb-2">1000+</div>
                        <div class="text-blue-100 text-sm">Students</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-white mb-2">50+</div>
                        <div class="text-blue-100 text-sm">Teachers</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-white mb-2">15+</div>
                        <div class="text-blue-100 text-sm">Years</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-white mb-2">100%</div>
                        <div class="text-blue-100 text-sm">Success</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-12 lg:items-center">
            <div class="mb-12 lg:mb-0">
                <img src="{{ asset('images/about-school.jpg') }}" alt="Al-Maghrib International School" class="rounded-2xl shadow-xl w-full h-96 object-cover">
            </div>
            <div>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
                    About Al-Maghrib International School
                </h2>
                <p class="text-lg text-gray-600 mb-6">
                    Al-Maghrib International School is committed to providing quality education that combines academic excellence with Islamic values. Our comprehensive curriculum prepares students for both worldly success and spiritual growth.
                </p>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="shrink-0">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="ml-3 text-gray-600">Cambridge International Curriculum</p>
                    </div>
                    <div class="flex items-start">
                        <div class="shrink-0">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="ml-3 text-gray-600">Islamic Studies & Moral Education</p>
                    </div>
                    <div class="flex items-start">
                        <div class="shrink-0">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="ml-3 text-gray-600">Modern Facilities & Technology</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Programs Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Our Programs</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Comprehensive educational programs designed to nurture academic excellence and character development
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Elementary -->
            <div class="relative group">
                <div class="bg-linear-to-br from-blue-50 to-blue-100 rounded-2xl p-8 h-full transition-transform duration-300 group-hover:scale-105">
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Elementary (KG-5)</h3>
                    <p class="text-gray-600 mb-4">Foundation years focused on basic literacy, numeracy, and Islamic values through play-based learning.</p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>• Phonics & Early Reading</li>
                        <li>• Mathematics Foundations</li>
                        <li>• Islamic Studies</li>
                        <li>• Creative Arts</li>
                    </ul>
                </div>
            </div>
            
            <!-- Middle School -->
            <div class="relative group">
                <div class="bg-linear-to-br from-green-50 to-green-100 rounded-2xl p-8 h-full transition-transform duration-300 group-hover:scale-105">
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Middle School (6-8)</h3>
                    <p class="text-gray-600 mb-4">Bridging elementary foundations with advanced concepts while strengthening Islamic identity.</p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>• Advanced Mathematics</li>
                        <li>• Science & Technology</li>
                        <li>• Islamic History</li>
                        <li>• Leadership Skills</li>
                    </ul>
                </div>
            </div>
            
            <!-- High School -->
            <div class="relative group">
                <div class="bg-linear-to-br from-purple-50 to-purple-100 rounded-2xl p-8 h-full transition-transform duration-300 group-hover:scale-105">
                    <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">High School (9-12)</h3>
                    <p class="text-gray-600 mb-4">Cambridge IGCSE & A-Level preparation for university admission and career readiness.</p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>• IGCSE Subjects</li>
                        <li>• A-Level Programs</li>
                        <li>• University Preparation</li>
                        <li>• Career Guidance</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission Section -->
<section class="py-16 bg-linear-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Our Vision & Mission</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Guided by Islamic principles and academic excellence
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Vision -->
            <div class="text-center lg:text-left">
                <div class="mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 text-blue-600 rounded-xl mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Vision</h3>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        To be a leading Islamic educational institution that nurtures confident, compassionate, and capable individuals who contribute positively to society while maintaining their Islamic identity and values.
                    </p>
                </div>
            </div>
            
            <!-- Mission -->
            <div class="text-center lg:text-left">
                <div class="mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 text-green-600 rounded-xl mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h3>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        To provide quality education that integrates academic excellence with Islamic teachings, fostering critical thinking, creativity, and moral development in a supportive and inclusive environment.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- News & Events -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Latest News & Events</h2>
            <p class="text-lg text-gray-600">Stay updated with our school activities and announcements</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- News Item 1 -->
            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="h-48 bg-linear-to-r from-blue-400 to-blue-600"></div>
                <div class="p-6">
                    <div class="text-sm text-blue-600 font-medium mb-2">News</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Annual Sports Day 2024</h3>
                    <p class="text-gray-600 mb-4">Join us for our annual sports day celebration featuring various competitions and activities...</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">March 15, 2024</span>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Read More</a>
                    </div>
                </div>
            </article>
            
            <!-- News Item 2 -->
            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="h-48 bg-linear-to-r from-green-400 to-green-600"></div>
                <div class="p-6">
                    <div class="text-sm text-green-600 font-medium mb-2">Event</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Science Fair 2024</h3>
                    <p class="text-gray-600 mb-4">Students showcase their innovative science projects and experiments...</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">March 20, 2024</span>
                        <a href="#" class="text-green-600 hover:text-green-800 font-medium">Read More</a>
                    </div>
                </div>
            </article>
            
            <!-- News Item 3 -->
            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="h-48 bg-linear-to-r from-purple-400 to-purple-600"></div>
                <div class="p-6">
                    <div class="text-sm text-purple-600 font-medium mb-2">Achievement</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Cambridge Results Excellence</h3>
                    <p class="text-gray-600 mb-4">Our students achieve outstanding results in Cambridge IGCSE and A-Level examinations...</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">March 10, 2024</span>
                        <a href="#" class="text-purple-600 hover:text-purple-800 font-medium">Read More</a>
                    </div>
                </div>
            </article>
        </div>
        
        <div class="text-center mt-12">
            <a href="#" class="inline-flex items-center px-6 py-3 border border-blue-600 text-base font-medium rounded-lg text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
                View All News & Events
                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Facilities Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">World-Class Facilities</h2>
            <p class="text-lg text-gray-600">Modern infrastructure designed to enhance learning experiences</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Facility 1 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Science Labs</h3>
                <p class="text-gray-600 text-sm">Fully equipped physics, chemistry, and biology laboratories</p>
            </div>
            
            <!-- Facility 2 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Smart Classrooms</h3>
                <p class="text-gray-600 text-sm">Interactive whiteboards and modern learning technology</p>
            </div>
            
            <!-- Facility 3 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Library</h3>
                <p class="text-gray-600 text-sm">Extensive collection of books and digital resources</p>
            </div>
            
            <!-- Facility 4 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.5a1.5 1.5 0 011.5 1.5v1a1.5 1.5 0 01-1.5 1.5H9m-3 1c0 1.5.5 3 2 3s2-1.5 2-3m7-1c0 1.5-.5 3-2 3s-2-1.5-2-3m3-9v2m0 0V5a2 2 0 00-2-2h-4"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Sports Complex</h3>
                <p class="text-gray-600 text-sm">Multi-purpose courts and athletic facilities</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-linear-to-r from-blue-900 to-blue-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold mb-6">Ready to Join Our Community?</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
            Give your child the best Islamic education combined with academic excellence. Apply now for admission.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#admissions" class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-lg text-blue-900 bg-white hover:bg-gray-100 transition-colors">
                Apply for Admission
                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
            <a href="#contact" class="inline-flex items-center px-8 py-4 border-2 border-white text-lg font-medium rounded-lg text-white hover:bg-white hover:text-blue-900 transition-colors">
                Schedule a Visit
            </a>
        </div>
    </div>
</section>
@endsection