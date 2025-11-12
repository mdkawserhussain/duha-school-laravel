@extends('layouts.app')

@section('title', 'Academics - Al-Maghrib International School')
@section('meta-description', 'Discover our comprehensive Islamic and Cambridge curriculum program at Al-Maghrib International School, offering quality education from Kindergarten to Grade 12')

@section('content')

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-green-600 to-green-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Academic Excellence</h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                    Comprehensive Islamic and Cambridge curriculum education for holistic development
                </p>
            </div>
        </div>
    </section>

    <!-- Curriculum Overview -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Curriculum</h2>
                <p class="text-lg text-gray-600">A perfect blend of Islamic teachings and international academic standards</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Islamic Studies -->
                <div class="bg-green-50 p-8 rounded-lg">
                    <div class="flex items-center mb-6">
                        <div class="bg-green-100 rounded-full p-3 mr-4">
                            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Islamic Studies</h3>
                    </div>
                    <div class="space-y-4 text-gray-700">
                        <p>Our Islamic Studies program covers:</p>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>Quran memorization and recitation (Hifz)</li>
                            <li>Islamic history and civilization</li>
                            <li>Arabic language proficiency</li>
                            <li>Islamic ethics and moral education</li>
                            <li>Fiqh (Islamic jurisprudence)</li>
                            <li>Hadith studies</li>
                        </ul>
                    </div>
                </div>

                <!-- Cambridge Curriculum -->
                <div class="bg-blue-50 p-8 rounded-lg">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-100 rounded-full p-3 mr-4">
                            <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Cambridge Curriculum</h3>
                    </div>
                    <div class="space-y-4 text-gray-700">
                        <p>Internationally recognized academic program including:</p>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>Cambridge Primary (Grades 1-5)</li>
                            <li>Cambridge Lower Secondary (Grades 6-8)</li>
                            <li>Cambridge IGCSE (Grades 9-10)</li>
                            <li>Cambridge AS & A Level (Grades 11-12)</li>
                            <li>English, Mathematics, Science</li>
                            <li>Social Studies, Arts, and more</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Grade Levels -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Grade Levels</h2>
                <p class="text-lg text-gray-600">Structured learning from Kindergarten to Grade 12</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Kindergarten -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-center mb-4">
                        <div class="bg-yellow-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                            <span class="text-yellow-600 font-bold text-lg">K</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Kindergarten</h3>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>• Play-based learning</li>
                        <li>• Basic Islamic concepts</li>
                        <li>• Social skills development</li>
                        <li>• Creative activities</li>
                        <li>• Age: 4-5 years</li>
                    </ul>
                </div>

                <!-- Primary (1-5) -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-center mb-4">
                        <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                            <span class="text-blue-600 font-bold text-lg">1-5</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Primary</h3>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>• Cambridge Primary curriculum</li>
                        <li>• Quran reading skills</li>
                        <li>• Basic mathematics</li>
                        <li>• English language</li>
                        <li>• Age: 6-10 years</li>
                    </ul>
                </div>

                <!-- Secondary (6-8) -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-center mb-4">
                        <div class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                            <span class="text-green-600 font-bold text-lg">6-8</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Lower Secondary</h3>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>• Cambridge Lower Secondary</li>
                        <li>• Advanced Islamic studies</li>
                        <li>• Science & Technology</li>
                        <li>• Social studies</li>
                        <li>• Age: 11-13 years</li>
                    </ul>
                </div>

                <!-- IGCSE/AS Level (9-12) -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-center mb-4">
                        <div class="bg-purple-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                            <span class="text-purple-600 font-bold text-lg">9-12</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">IGCSE & A Level</h3>
                    </div>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>• Cambridge IGCSE</li>
                        <li>• Cambridge AS/A Level</li>
                        <li>• Career guidance</li>
                        <li>• University preparation</li>
                        <li>• Age: 14-17 years</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Academic Features -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Academic Features</h2>
                <p class="text-lg text-gray-600">What sets our academic program apart</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Individual Attention</h3>
                    <p class="text-gray-600">Small class sizes ensure personalized attention for every student</p>
                </div>

                <div class="text-center">
                    <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Modern Facilities</h3>
                    <p class="text-gray-600">State-of-the-art classrooms, labs, and learning resources</p>
                </div>

                <div class="text-center">
                    <div class="bg-yellow-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Experienced Faculty</h3>
                    <p class="text-gray-600">Qualified teachers with expertise in Islamic and Cambridge education</p>
                </div>

                <div class="text-center">
                    <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Assessment & Progress</h3>
                    <p class="text-gray-600">Regular assessments and progress reports for continuous improvement</p>
                </div>

                <div class="text-center">
                    <div class="bg-red-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Character Development</h3>
                    <p class="text-gray-600">Focus on Islamic character building alongside academic excellence</p>
                </div>

                <div class="text-center">
                    <div class="bg-indigo-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-1.657 0-3-4.03-3-9s1.343-9 3-9m0 9c1.657 0 3 4.03 3 9s-1.343 9-3 9m-9 9v-9m0-9v9"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Global Recognition</h3>
                    <p class="text-gray-600">Cambridge qualifications recognized worldwide by universities</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Subjects Offered -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Subjects Offered</h2>
                <p class="text-lg text-gray-600">Comprehensive curriculum covering all essential areas</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Core Subjects</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>• English Language & Literature</li>
                        <li>• Mathematics</li>
                        <li>• Islamic Studies</li>
                        <li>• Arabic Language</li>
                        <li>• Quran & Hadith</li>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Science Subjects</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>• Physics</li>
                        <li>• Chemistry</li>
                        <li>• Biology</li>
                        <li>• Computer Science</li>
                        <li>• Environmental Science</li>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Social Sciences</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>• History</li>
                        <li>• Geography</li>
                        <li>• Sociology</li>
                        <li>• Economics</li>
                        <li>• Global Perspectives</li>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Arts & Humanities</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>• Art & Design</li>
                        <li>• Music</li>
                        <li>• Physical Education</li>
                        <li>• Islamic History</li>
                        <li>• Moral Education</li>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Languages</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>• Bengali</li>
                        <li>• Arabic</li>
                        <li>• French</li>
                        <li>• Urdu/Hindi</li>
                        <li>• Additional Languages</li>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Co-curricular</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>• Debate & Public Speaking</li>
                        <li>• Sports & Athletics</li>
                        <li>• Community Service</li>
                        <li>• Leadership Programs</li>
                        <li>• Cultural Activities</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-green-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Experience Academic Excellence</h2>
            <p class="text-xl mb-8">Join our community of learners and discover the perfect balance of faith and knowledge</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('admission.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-3 px-8 rounded-lg transition duration-300">
                    Apply for Admission
                </a>
                <a href="{{ route('contact.index') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 border border-white text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                    Learn More
                </a>
            </div>
        </div>
    </section>

@endsection