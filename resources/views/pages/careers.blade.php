@extends('layouts.app')

@section('title', 'Careers - Al-Maghrib International School')
@section('meta-description', 'Join our team at Al-Maghrib International School. Explore teaching and administrative positions in our Islamic and Cambridge curriculum school')

@section('content')

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-green-600 to-green-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Join Our Team</h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                    Be part of our mission to provide quality Islamic and Cambridge curriculum education
                </p>
                <a href="#career-form" class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-3 px-8 rounded-lg transition duration-300">
                    Apply Now
                </a>
            </div>
        </div>
    </section>

    <!-- Why Work With Us -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Work at Al-Maghrib?</h2>
                <p class="text-lg text-gray-600">A rewarding career in Islamic education</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Islamic Environment</h3>
                    <p class="text-gray-600">Work in a supportive Islamic educational environment</p>
                </div>

                <div class="text-center">
                    <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Professional Growth</h3>
                    <p class="text-gray-600">Continuous professional development opportunities</p>
                </div>

                <div class="text-center">
                    <div class="bg-yellow-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Community Impact</h3>
                    <p class="text-gray-600">Make a difference in young minds and the community</p>
                </div>

                <div class="text-center">
                    <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Work-Life Balance</h3>
                    <p class="text-gray-600">Competitive benefits and supportive work environment</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Current Openings -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Current Openings</h2>
                <p class="text-lg text-gray-600">Join our dedicated team of educators and professionals</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <!-- Position 1 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">Islamic Studies Teacher</h3>
                            <p class="text-green-600 font-medium">Full-time Position</p>
                        </div>
                        <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">Urgent</span>
                    </div>
                    <p class="text-gray-600 mb-4">We are seeking a qualified Islamic Studies teacher to join our team for the upcoming academic year.</p>
                    <div class="mb-4">
                        <h4 class="font-medium text-gray-900 mb-2">Requirements:</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Bachelor's degree in Islamic Studies or related field</li>
                            <li>• Teaching certification preferred</li>
                            <li>• Experience with Cambridge curriculum</li>
                            <li>• Strong communication skills</li>
                        </ul>
                    </div>
                    <button onclick="selectPosition('Islamic Studies Teacher')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
                        Apply for this Position
                    </button>
                </div>

                <!-- Position 2 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">Mathematics Teacher</h3>
                            <p class="text-green-600 font-medium">Full-time Position</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">Join our mathematics department to teach Cambridge curriculum mathematics to secondary students.</p>
                    <div class="mb-4">
                        <h4 class="font-medium text-gray-900 mb-2">Requirements:</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Bachelor's degree in Mathematics or related field</li>
                            <li>• Teaching experience preferred</li>
                            <li>• Familiarity with Cambridge IGCSE/O Level</li>
                            <li>• Passion for teaching</li>
                        </ul>
                    </div>
                    <button onclick="selectPosition('Mathematics Teacher')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
                        Apply for this Position
                    </button>
                </div>

                <!-- Position 3 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">Administrative Assistant</h3>
                            <p class="text-blue-600 font-medium">Full-time Position</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">Support our administrative team in managing school operations and student services.</p>
                    <div class="mb-4">
                        <h4 class="font-medium text-gray-900 mb-2">Requirements:</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Bachelor's degree in Business Administration or related</li>
                            <li>• Administrative experience preferred</li>
                            <li>• Proficient in MS Office</li>
                            <li>• Strong organizational skills</li>
                        </ul>
                    </div>
                    <button onclick="selectPosition('Administrative Assistant')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
                        Apply for this Position
                    </button>
                </div>

                <!-- Position 4 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">Science Laboratory Technician</h3>
                            <p class="text-blue-600 font-medium">Part-time Position</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">Maintain and support our science laboratories for effective teaching and learning.</p>
                    <div class="mb-4">
                        <h4 class="font-medium text-gray-900 mb-2">Requirements:</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Diploma in Science or related field</li>
                            <li>• Laboratory experience preferred</li>
                            <li>• Knowledge of laboratory safety</li>
                            <li>• Attention to detail</li>
                        </ul>
                    </div>
                    <button onclick="selectPosition('Science Laboratory Technician')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
                        Apply for this Position
                    </button>
                </div>
            </div>

            <div class="text-center">
                <p class="text-gray-600 mb-4">Don't see a position that matches your skills?</p>
                <button onclick="selectPosition('General Application')" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                    Submit General Application
                </button>
            </div>
        </div>
    </section>

    <!-- Application Form -->
    <section id="career-form" class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-50 rounded-lg shadow-lg p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Career Application Form</h2>
                    <p class="text-gray-600">Join our team and make a difference in Islamic education</p>
                </div>

                <form method="POST" action="{{ route('careers.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Position Applied For -->
                    <div>
                        <label for="job_title" class="block text-sm font-medium text-gray-700 mb-1">Position Applied For *</label>
                        <select id="job_title" name="job_title"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('job_title') border-red-500 @enderror" required>
                            <option value="">Select Position</option>
                            <option value="Islamic Studies Teacher" {{ old('job_title') == 'Islamic Studies Teacher' ? 'selected' : '' }}>Islamic Studies Teacher</option>
                            <option value="Mathematics Teacher" {{ old('job_title') == 'Mathematics Teacher' ? 'selected' : '' }}>Mathematics Teacher</option>
                            <option value="Administrative Assistant" {{ old('job_title') == 'Administrative Assistant' ? 'selected' : '' }}>Administrative Assistant</option>
                            <option value="Science Laboratory Technician" {{ old('job_title') == 'Science Laboratory Technician' ? 'selected' : '' }}>Science Laboratory Technician</option>
                            <option value="General Application" {{ old('job_title') == 'General Application' ? 'selected' : '' }}>General Application</option>
                        </select>
                        @error('job_title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Personal Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="applicant_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <input type="text" id="applicant_name" name="applicant_name" value="{{ old('applicant_name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('applicant_name') border-red-500 @enderror" required>
                            @error('applicant_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cover Letter -->
                    <div>
                        <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-1">Cover Letter</label>
                        <textarea id="cover_letter" name="cover_letter" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('cover_letter') border-red-500 @enderror"
                                  placeholder="Tell us why you're interested in this position and what makes you a good fit...">{{ old('cover_letter') }}</textarea>
                        @error('cover_letter')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Resume Upload -->
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="text-md font-semibold text-gray-900 mb-2">Resume/CV Upload *</h4>
                        <p class="text-sm text-gray-600 mb-3">Please upload your resume in PDF format (Maximum 5MB)</p>
                        <div>
                            <label for="resume" class="block text-sm font-medium text-gray-700 mb-1">Select Resume File</label>
                            <input type="file" id="resume" name="resume" accept=".pdf"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('resume') border-red-500 @enderror" required>
                            @error('resume')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                            Submit Application
                        </button>
                        <p class="text-sm text-gray-600 mt-2">By submitting this application, you agree to our privacy policy and terms of service.</p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        function selectPosition(position) {
            document.getElementById('job_title').value = position;
            document.getElementById('career-form').scrollIntoView({ behavior: 'smooth' });
        }
    </script>

@endsection