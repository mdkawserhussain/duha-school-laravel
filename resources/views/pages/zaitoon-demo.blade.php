{{-- Zaitoon Academy Component Demo Page --}}
@extends('layouts.app')

@section('title', 'Zaitoon Academy - Component Demo')

@section('content')

{{-- Include scroll animations --}}
<x-utilities.scroll-animations />

{{-- Hero Slider --}}
@php
$heroSlides = [
    [
        'image' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=1920&h=800&fit=crop',
        'title' => 'Welcome to Zaitoon Academy',
        'subtitle' => 'Excellence in Education',
        'description' => 'Nurturing future leaders with strong moral character and academic excellence through Islamic and contemporary education.',
        'ctaPrimary' => ['text' => 'Apply Now', 'url' => '#admission'],
        'ctaSecondary' => ['text' => 'Learn More', 'url' => '#about'],
    ],
    [
        'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920&h=800&fit=crop',
        'title' => 'Cambridge Curriculum',
        'subtitle' => 'World-Class Education',
        'description' => 'Our students excel with a balanced blend of Cambridge International curriculum and Islamic studies.',
        'ctaPrimary' => ['text' => 'View Programs', 'url' => '#programs'],
        'ctaSecondary' => ['text' => 'Schedule Tour', 'url' => '#tour'],
    ],
    [
        'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=1920&h=800&fit=crop',
        'title' => 'State-of-the-Art Facilities',
        'subtitle' => 'Modern Learning Environment',
        'description' => 'Experience education in our modern classrooms, laboratories, and sports facilities designed for holistic development.',
        'ctaPrimary' => ['text' => 'Virtual Tour', 'url' => '#facilities'],
        'ctaSecondary' => ['text' => 'Contact Us', 'url' => '#contact'],
    ],
];
@endphp

<x-hero-slider-zaitoon :slides="$heroSlides" :autoplay="true" :interval="5000" />

{{-- Stats Section --}}
<x-templates.section bgColor="bg-white" padding="lg" id="stats">
    <x-slot name="heading">
        <h2 class="text-4xl font-serif font-bold text-za-green-primary text-center mb-4">
            Zaitoon Academy in Numbers
        </h2>
        <p class="text-lg text-gray-600 text-center max-w-3xl mx-auto mb-12">
            Building excellence through dedication and commitment to quality education
        </p>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <x-molecules.stat-counter 
            :value="500" 
            label="Students Enrolled" 
            suffix="+"
            :icon="'<svg class=\"w-8 h-8\" fill=\"currentColor\" viewBox=\"0 0 20 20\"><path d=\"M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z\"></path></svg>'"
        />
        <x-molecules.stat-counter 
            :value="50" 
            label="Qualified Teachers" 
            suffix="+"
            :icon="'<svg class=\"w-8 h-8\" fill=\"currentColor\" viewBox=\"0 0 20 20\"><path d=\"M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z\"></path></svg>'"
        />
        <x-molecules.stat-counter 
            :value="15" 
            label="Years of Excellence"
            :icon="'<svg class=\"w-8 h-8\" fill=\"currentColor\" viewBox=\"0 0 20 20\"><path fill-rule=\"evenodd\" d=\"M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z\" clip-rule=\"evenodd\"></path></svg>'"
        />
        <x-molecules.stat-counter 
            :value="95" 
            label="Success Rate" 
            suffix="%"
            :icon="'<svg class=\"w-8 h-8\" fill=\"currentColor\" viewBox=\"0 0 20 20\"><path d=\"M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z\"></path></svg>'"
        />
    </div>
</x-templates.section>

{{-- Features Section --}}
<x-templates.section bgColor="bg-za-green-light" padding="xl" textAlign="center" id="features">
    <x-slot name="heading">
        <h2 class="text-4xl font-serif font-bold text-za-green-primary mb-4">
            Why Choose Zaitoon Academy?
        </h2>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">
            A comprehensive Islamic and modern education that prepares students for success in this world and the hereafter
        </p>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <x-molecules.feature-card 
            :icon="'<svg class=\"w-8 h-8\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253\"></path></svg>'"
            title="Islamic & Modern Curriculum"
            description="Integrating Cambridge International curriculum with comprehensive Islamic studies, Quran, and Arabic language education."
            link="#curriculum"
        />
        
        <x-molecules.feature-card 
            :icon="'<svg class=\"w-8 h-8\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z\"></path></svg>'"
            title="Experienced Faculty"
            description="Dedicated and qualified teachers with years of experience in both Islamic and contemporary education methodologies."
            link="#faculty"
        />
        
        <x-molecules.feature-card 
            :icon="'<svg class=\"w-8 h-8\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4\"></path></svg>'"
            title="Modern Facilities"
            description="State-of-the-art classrooms, science laboratories, computer labs, library, and sports facilities for holistic development."
            link="#facilities"
        />
        
        <x-molecules.feature-card 
            :icon="'<svg class=\"w-8 h-8\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7\"></path></svg>'"
            title="Character Building"
            description="Focus on moral values, ethics, and character development through Islamic teachings and practical life skills."
            link="#character"
        />
        
        <x-molecules.feature-card 
            :icon="'<svg class=\"w-8 h-8\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z\"></path></svg>'"
            title="Global Perspective"
            description="Preparing students for international opportunities while maintaining strong Islamic identity and cultural values."
            link="#global"
        />
        
        <x-molecules.feature-card 
            :icon="'<svg class=\"w-8 h-8\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5\"></path></svg>'"
            title="Extracurricular Activities"
            description="Sports, arts, science clubs, and Islamic competitions to develop well-rounded personalities and leadership skills."
            link="#activities"
        />
    </div>
</x-templates.section>

{{-- Events Section --}}
<x-templates.section bgColor="bg-white" padding="lg" id="events">
    <x-slot name="heading">
        <div class="flex flex-col md:flex-row justify-between items-center mb-12">
            <div>
                <h2 class="text-4xl font-serif font-bold text-za-green-primary mb-2">
                    Latest Events & News
                </h2>
                <p class="text-gray-600">Stay updated with our activities and achievements</p>
            </div>
            <a href="#all-events" class="mt-4 md:mt-0 inline-flex items-center text-za-green-primary font-semibold hover:text-za-yellow-accent transition-colors group">
                <span>View All Events</span>
                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <x-molecules.event-card 
            image="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&h=600&fit=crop"
            title="Annual Science Fair 2024"
            date="Dec 15"
            category="Academic"
            excerpt="Students showcase innovative projects and experiments in our annual science exhibition. Join us for a day of discovery and learning."
            link="#event-1"
            :featured="true"
        />
        
        <x-molecules.event-card 
            image="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=800&h=600&fit=crop"
            title="Quran Recitation Competition"
            date="Dec 20"
            category="Islamic"
            excerpt="Students compete in beautiful recitation of the Holy Quran with proper tajweed and understanding."
            link="#event-2"
        />
        
        <x-molecules.event-card 
            image="https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800&h=600&fit=crop"
            title="Sports Day Championship"
            date="Jan 5"
            category="Sports"
            excerpt="Annual inter-house sports competition featuring athletics, football, basketball, and traditional games."
            link="#event-3"
        />
    </div>
</x-templates.section>

{{-- Testimonials Section --}}
<x-templates.section bgColor="bg-za-green-light" padding="xl" textAlign="center" id="testimonials">
    <x-slot name="heading">
        <h2 class="text-4xl font-serif font-bold text-za-green-primary mb-4">
            What Parents Say
        </h2>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto mb-12">
            Hear from our satisfied parents about their experience with Zaitoon Academy
        </p>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <x-molecules.testimonial-card 
            quote="Zaitoon Academy has transformed my child's education journey. The combination of Islamic values and academic excellence is unmatched. I highly recommend it to every parent looking for quality education."
            author="Ahmed Khan"
            role="Parent of Grade 8 Student"
            avatar="https://ui-avatars.com/api/?name=Ahmed+Khan&background=1a5e4a&color=fff"
            :rating="5"
        />
        
        <x-molecules.testimonial-card 
            quote="My daughter loves the learning environment here! The teachers are caring, knowledgeable, and truly invested in each student's success. The Islamic studies program is comprehensive and engaging."
            author="Fatima Ali"
            role="Parent of Grade 5 Student"
            avatar="https://ui-avatars.com/api/?name=Fatima+Ali&background=1a5e4a&color=fff"
            :rating="5"
        />
        
        <x-molecules.testimonial-card 
            quote="Best decision we made for our child's education. The balance between modern curriculum and Islamic teachings prepares students for both worldly success and spiritual growth."
            author="Omar Hassan"
            role="Parent of Grade 10 Student"
            avatar="https://ui-avatars.com/api/?name=Omar+Hassan&background=1a5e4a&color=fff"
            :rating="5"
        />
    </div>
</x-templates.section>

{{-- Contact Form Section --}}
<x-templates.section bgColor="bg-white" padding="xl" id="contact">
    <x-slot name="heading">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-serif font-bold text-za-green-primary mb-4">
                Get in Touch
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
            </p>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <x-organisms.contact-form 
            submitUrl="/contact"
        />
    </div>
</x-templates.section>

{{-- Modal Example --}}
<x-organisms.modal id="welcome-modal" size="md" title="Welcome to Zaitoon Academy">
    <div class="space-y-4">
        <p class="text-gray-700">
            Thank you for visiting our component demo page! This modal demonstrates the modal component functionality.
        </p>
        <p class="text-gray-700">
            All components are built with Alpine.js, Tailwind CSS, and Laravel Blade for maximum flexibility and maintainability.
        </p>
        <div class="flex justify-end gap-3 mt-6">
            <button 
                @click="$dispatch('modal-close-welcome-modal')"
                class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
            >
                Close
            </button>
            <button 
                @click="$dispatch('modal-close-welcome-modal')"
                class="px-6 py-2 bg-za-yellow-accent hover:bg-za-yellow-dark text-za-green-dark font-semibold rounded-lg transition-colors"
            >
                Got it!
            </button>
        </div>
    </div>
</x-organisms.modal>

{{-- Floating Action Button to Open Modal --}}
<button
    @click="$dispatch('modal-open-welcome-modal')"
    class="fixed bottom-24 right-8 w-14 h-14 bg-za-green-primary hover:bg-za-green-dark text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-110 flex items-center justify-center z-40 group"
    title="Open Demo Modal"
>
    <svg class="w-6 h-6 transform group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
    </svg>
</button>

@endsection

@push('scripts')
<script>
// Auto-open welcome modal after 2 seconds (optional)
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        // Uncomment to auto-open modal
        // window.dispatchEvent(new CustomEvent('modal-open-welcome-modal'));
    }, 2000);
});
</script>
@endpush
