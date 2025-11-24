@extends('layouts.app')

@section('title', 'About Us - Al-Maghrib')

@section('content')
    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-[#E8F5E9] via-white to-[#E8F5E9] py-20 lg:py-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                {{-- Left Content --}}
                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" 
                     class="text-center lg:text-left space-y-6">
                    <h1 class="text-4xl lg:text-6xl font-bold text-[#0d5a47] opacity-0 transform translate-y-8 transition-all duration-1000 ease-out"
                        :class="{ 'opacity-100 translate-y-0': show }">
                        Welcome to Al-Maghrib
                    </h1>
                    <p class="text-gray-600 text-lg leading-relaxed opacity-0 transform translate-y-8 transition-all duration-1000 delay-300 ease-out"
                       :class="{ 'opacity-100 translate-y-0': show }">
                        Al-Maghrib is committed to ensuring a high standard of education, combining modern curriculum with moral values to prepare students for a bright future.
                    </p>
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start opacity-0 transform translate-y-8 transition-all duration-1000 delay-500 ease-out"
                         :class="{ 'opacity-100 translate-y-0': show }">
                        <a href="{{ route('admission.index') }}" class="px-8 py-3 bg-[#0d5a47] text-white font-semibold rounded hover:bg-[#0a4839] transition-colors shadow-lg hover:shadow-xl">
                            Apply Online
                        </a>
                        <a href="#" class="px-8 py-3 bg-white text-[#0d5a47] border border-[#0d5a47] font-semibold rounded hover:bg-gray-50 transition-colors shadow-sm hover:shadow-md">
                            Learn More
                        </a>
                    </div>
                </div>

                {{-- Right Logo --}}
                <div class="relative flex justify-center lg:justify-end" x-data>
                    <div class="relative w-72 h-96 bg-[#1e40af] rounded-lg shadow-2xl flex flex-col items-center justify-center p-8 animate-float">
                        {{-- Icon --}}
                        <div class="w-32 h-32 mb-8 flex items-center justify-center">
                            <svg viewBox="0 0 200 200" class="w-full h-full drop-shadow-lg">
                                <circle cx="100" cy="80" r="45" fill="#fbbf24"/>
                                <path d="M100 125 L75 165 L125 165 Z" fill="#fbbf24"/>
                            </svg>
                        </div>
                        {{-- Header --}}
                        <div class="text-center space-y-2">
                            <h3 class="text-3xl font-bold text-white tracking-wide">Al-Maghrib</h3>
                            <p class="text-white/90 text-lg font-medium">International School</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Decorative Background Elements --}}
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-[#7AB91E]/10 to-transparent skew-x-12 transform origin-top-right"></div>
        <div class="absolute bottom-0 left-0 w-1/4 h-1/2 bg-gradient-to-t from-[#0d5a47]/5 to-transparent rounded-tr-full"></div>
    </section>

    {{-- Introduction Section --}}
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-[#0d5a47] mb-8">Al-Maghrib</h2>
            <div class="space-y-6 text-gray-700 leading-relaxed text-justify">
                <p>
                    Al-Maghrib was conceived, founded, and promoted by Dr. Muhammad Aminul Hoque, Associate Professor and Former Chairman of the Department of Da’wah & Islamic Studies at the International Islamic University Chittagong. Al-Maghrib commenced operations in a hired building at Jalalabad Housing Society in West Khulshi, Chattogram Metropolitan, on March 1, 2023.
                </p>
                <p>
                    The academy aims to provide a balanced education that integrates general education with Islamic values. It strives to create an environment where students can develop their intellectual, physical, and spiritual potential to the fullest.
                </p>
                <p>
                    Our curriculum is designed to meet the challenges of the 21st century while keeping our students rooted in their cultural and religious heritage. We believe in nurturing future leaders who are not only academically competent but also morally upright.
                </p>
            </div>
        </div>
    </section>

    {{-- Mission & Vision --}}
    <section class="py-16 bg-[#F9FAFB]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-[#0d5a47] mb-6">Our Mission & Vision</h2>
            <p class="text-gray-700 text-lg italic">
                "Growing a generation of students who are intellectually competent, spiritually mature, and socially responsible leaders for the community and the nation."
            </p>
        </div>
    </section>

    {{-- Core Values --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-[#0d5a47] text-center mb-12">Our Core Values</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach(['Islamic Faith & Culture', 'Prophetic Character', 'Lifelong Learning', 'Quality Community', 'Skill-based Learning', 'Intellectual Development'] as $value)
                <div class="group bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-xl transition duration-500 ease-in-out hover:scale-105">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-[#E8F5E9] flex items-center justify-center group-hover:bg-[#0d5a47] group-hover:scale-110 transition duration-500 ease-in-out">
                            <svg class="w-5 h-5 text-[#0d5a47] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="font-semibold text-gray-800 group-hover:text-[#0d5a47] transition-colors duration-300">{{ $value }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Specialties --}}
    <section class="py-16 bg-[#F0FDF4]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-[#0d5a47] text-center mb-12">Specialties of Al-Maghrib</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                @foreach(['Hifzul Quran with schooling', 'Special proficiency in Arabic Language', 'Modern education integrated with moral values', 'Certificate of Hifzul Quran'] as $specialty)
                <div class="bg-[#E8F5E9] rounded-lg p-6 flex items-center gap-4 hover:shadow-lg transition duration-500 ease-in-out hover:scale-105">
                    <div class="w-2 h-8 bg-[#0d5a47] rounded-full"></div>
                    <span class="font-semibold text-[#0d5a47]">{{ $specialty }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Facilities --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-[#0d5a47] text-center mb-12">Our Facilities</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $facilities = [
                        ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'title' => 'Cambridge & National Curriculum'],
                        ['icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'title' => 'Computer & Language Lab'],
                        ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'title' => 'Adult Learning Center'],
                        ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'title' => 'Modern Library with WiFi'],
                        ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Uninterruptible Power Supply'],
                        ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z', 'title' => 'Counseling & Career Guidelines'],
                    ];
                @endphp
                
                @foreach($facilities as $facility)
                <div class="bg-white border border-gray-100 rounded-xl p-8 text-center shadow-sm hover:shadow-xl transition duration-500 ease-in-out hover:scale-105 group">
                    <div class="w-16 h-16 mx-auto bg-[#E8F5E9] rounded-full flex items-center justify-center mb-4 group-hover:bg-[#0d5a47] group-hover:scale-110 transition duration-500 ease-in-out">
                        <svg class="w-8 h-8 text-[#0d5a47] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $facility['icon'] }}"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-[#0d5a47] transition-colors duration-300">{{ $facility['title'] }}</h3>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Salient Facilities --}}
    <section class="py-16 bg-[#F9FAFB]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-[#0d5a47] text-center mb-12">The salient facilities of the Al-Maghrib are as follows</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                @foreach([
                    'We use female-prophetic soft spoken tone',
                    'A fun & parliamentary style present school, we expected to show their best character this style quran',
                    'All our pupils are expected to be clean and smart, both in school and on their way to and from school',
                    'Al-Maghrib encourages students to read, write & speak naturally by creating a natural environment where different languages such as English & Arabic',
                    'We offer both Cambridge & National Curriculum',
                    'A safe and secure playground for playing board boys where they can play under surveillance',
                    'A well-ventilated school with better ambience of the information on a click',
                    'Dedicated teachers monitor & help you to provide mental, physical & child growth in school',
                    'Video camera equipped campus',
                    'Pure water supply from centrally operated water plant',
                    '24 hours uninterrupted power supply',
                    'Well maintained sanitary facility',
                    'A rich digital process library',
                    'A full time special doctor on the premises',
                    'Spacious indoor playground',
                    'Computer Lab',
                    'Language Lab',
                    'Math Lab',
                    'Student careers & Counseling',
                    'Residential & Day care facilities for boys & girls'
                ] as $item)
                <div class="flex items-start gap-3 bg-white p-4 rounded-lg shadow-sm border-l-4 border-[#7AB91E] hover:shadow-md transition-shadow duration-300">
                    <div class="mt-1 flex-shrink-0 w-4 h-4 rounded-full bg-[#0d5a47] flex items-center justify-center">
                        <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-gray-700 text-sm">{{ $item }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
    </style>
@endsection