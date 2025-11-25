@extends('layouts.app')

@php
    $siteName = \App\Helpers\SiteSettingsHelper::websiteName() ?? 'Duha International School';
    $pageTitle = $page->title ?? 'About Us';
    
    // Handle page data - check if it's a Page model or fallback object
    $pageData = [];
    if (isset($page->data)) {
        $pageData = is_array($page->data) ? $page->data : (is_string($page->data) ? json_decode($page->data, true) ?? [] : []);
    }
    
    // Default values
    $missionVision = $pageData['mission_vision'] ?? 'Growing a generation of students who are intellectually competent, spiritually mature, and socially responsible leaders for the community and the nation.';
    $coreValues = $pageData['core_values'] ?? ['Islamic Faith & Culture', 'Prophetic Character', 'Lifelong Learning', 'Quality Community', 'Skill-based Learning', 'Intellectual Development'];
    $specialties = $pageData['specialties'] ?? ['Hifzul Quran with schooling', 'Special proficiency in Arabic Language', 'Modern education integrated with moral values', 'Certificate of Hifzul Quran'];
    $facilities = $pageData['facilities'] ?? [];
    $salientFacilities = $pageData['salient_facilities'] ?? [];
@endphp

@section('title', $pageTitle . ' - ' . $siteName)

@section('content')
    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-[#E8F5E9] via-white to-[#E8F5E9] py-20 lg:py-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                {{-- Left Content --}}
                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" 
                     class="text-center lg:text-left space-y-6">
                    <h1 class="text-4xl lg:text-6xl font-bold text-[#008236] opacity-0 transform translate-y-8 transition-all duration-1000 ease-out"
                        :class="{ 'opacity-100 translate-y-0': show }">
                        {{ $page->title ?? 'Welcome to ' . $siteName }}
                    </h1>
                    <p class="text-gray-600 text-lg leading-relaxed opacity-0 transform translate-y-8 transition-all duration-1000 delay-300 ease-out"
                       :class="{ 'opacity-100 translate-y-0': show }">
                        {{ $page->hero_subtitle ?? $page->excerpt ?? ($siteName . ' is committed to ensuring a high standard of education, combining modern curriculum with moral values to prepare students for a bright future.') }}
                    </p>
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start opacity-0 transform translate-y-8 transition-all duration-1000 delay-500 ease-out"
                         :class="{ 'opacity-100 translate-y-0': show }">
                        <a href="{{ route('admission.index') }}" class="px-8 py-3 bg-[#008236] text-white font-semibold rounded hover:bg-[#006a2b] transition-colors shadow-lg hover:shadow-xl">
                            Apply Online
                        </a>
                        <a href="#" class="px-8 py-3 bg-white text-[#008236] border border-[#008236] font-semibold rounded hover:bg-gray-50 transition-colors shadow-sm hover:shadow-md">
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
                            <h3 class="text-3xl font-bold text-white tracking-wide">{{ $siteName }}</h3>
                            <p class="text-white/90 text-lg font-medium">International School</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Decorative Background Elements --}}
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-[#7AB91E]/10 to-transparent skew-x-12 transform origin-top-right"></div>
        <div class="absolute bottom-0 left-0 w-1/4 h-1/2 bg-gradient-to-t from-[#008236]/5 to-transparent rounded-tr-full"></div>
    </section>

    {{-- Introduction Section --}}
    @if($page->content || (isset($page->data) && !empty($page->data)))
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-[#008236] mb-8">{{ $page->title ?? $siteName }}</h2>
            <div class="space-y-6 text-gray-700 leading-relaxed text-justify">
                @if($page->content)
                    {!! $page->content !!}
                @else
                    <p>
                        {{ $siteName }} was conceived, founded, and promoted by Dr. Muhammad Aminul Hoque, Associate Professor and Former Chairman of the Department of Da'wah & Islamic Studies at the International Islamic University Chittagong. {{ $siteName }} commenced operations in a hired building at Jalalabad Housing Society in West Khulshi, Chattogram Metropolitan, on March 1, 2023.
                    </p>
                    <p>
                        The academy aims to provide a balanced education that integrates general education with Islamic values. It strives to create an environment where students can develop their intellectual, physical, and spiritual potential to the fullest.
                    </p>
                    <p>
                        Our curriculum is designed to meet the challenges of the 21st century while keeping our students rooted in their cultural and religious heritage. We believe in nurturing future leaders who are not only academically competent but also morally upright.
                    </p>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- Mission & Vision --}}
    @if($missionVision)
    <section class="py-16 bg-[#F9FAFB]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-[#008236] mb-6">Our Mission & Vision</h2>
            <p class="text-gray-700 text-lg italic">
                "{{ $missionVision }}"
            </p>
        </div>
    </section>
    @endif

    {{-- Core Values --}}
    @if(!empty($coreValues))
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-[#008236] text-center mb-12">Our Core Values</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($coreValues as $value)
                <div class="group bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-xl transition duration-500 ease-in-out hover:scale-105">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-[#E8F5E9] flex items-center justify-center group-hover:bg-[#008236] group-hover:scale-110 transition duration-500 ease-in-out">
                            <svg class="w-5 h-5 text-[#008236] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="font-semibold text-gray-800 group-hover:text-[#008236] transition-colors duration-300">{{ $value }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Specialties --}}
    @if(!empty($specialties))
    <section class="py-16 bg-[#F0FDF4]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-[#008236] text-center mb-12">Specialties of {{ $siteName }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                @foreach($specialties as $specialty)
                <div class="bg-[#E8F5E9] rounded-lg p-6 flex items-center gap-4 hover:shadow-lg transition duration-500 ease-in-out hover:scale-105">
                    <div class="w-2 h-8 bg-[#008236] rounded-full"></div>
                    <span class="font-semibold text-[#008236]">{{ $specialty }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Facilities --}}
    @if(!empty($facilities))
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-[#008236] text-center mb-12">Our Facilities</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($facilities as $facility)
                <div class="bg-white border border-gray-100 rounded-xl p-8 text-center shadow-sm hover:shadow-xl transition duration-500 ease-in-out hover:scale-105 group">
                    @if(is_array($facility) && isset($facility['icon']))
                    <div class="w-16 h-16 mx-auto bg-[#E8F5E9] rounded-full flex items-center justify-center mb-4 group-hover:bg-[#008236] group-hover:scale-110 transition duration-500 ease-in-out">
                        <svg class="w-8 h-8 text-[#008236] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $facility['icon'] }}"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-[#008236] transition-colors duration-300">{{ $facility['title'] ?? $facility }}</h3>
                    @else
                    <div class="w-16 h-16 mx-auto bg-[#E8F5E9] rounded-full flex items-center justify-center mb-4 group-hover:bg-[#008236] group-hover:scale-110 transition duration-500 ease-in-out">
                        <svg class="w-8 h-8 text-[#008236] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-[#008236] transition-colors duration-300">{{ is_array($facility) ? ($facility['title'] ?? '') : $facility }}</h3>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Salient Facilities --}}
    @if(!empty($salientFacilities))
    <section class="py-16 bg-[#F9FAFB]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-[#008236] text-center mb-12">The salient facilities of {{ $siteName }} are as follows</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                @foreach($salientFacilities as $item)
                <div class="flex items-start gap-3 bg-white p-4 rounded-lg shadow-sm border-l-4 border-[#7AB91E] hover:shadow-md transition-shadow duration-300">
                    <div class="mt-1 flex-shrink-0 w-4 h-4 rounded-full bg-[#008236] flex items-center justify-center">
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
    @endif

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