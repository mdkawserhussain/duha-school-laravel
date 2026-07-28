{{-- Zaitoon Academy Footer Component --}}
@props(['showNewsletter' => false])  {{-- Changed default to false --}}

@php
    // Get site settings
    $physicalAddress = \App\Helpers\SiteSettingsHelper::physicalAddress();
    $primaryPhone = \App\Helpers\SiteSettingsHelper::primaryPhone();
    $primaryEmail = \App\Helpers\SiteSettingsHelper::primaryEmail();
    $businessHours = \App\Helpers\SiteSettingsHelper::businessHours();
    $socialLinks = \App\Helpers\SiteSettingsHelper::socialLinks();
    $siteName = \App\Helpers\SiteSettingsHelper::websiteName();
    $copyright = \App\Helpers\SiteSettingsHelper::copyrightNotice();
    
    // Get logo URL - same approach as header
    $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
@endphp

<footer class="relative text-white" style="margin-top: -1px; background-color: #0d5a47;">
    {{-- Curved Wave at Top - Smooth Transition --}}
    {{-- <div class="absolute top-0 left-0 w-full overflow-hidden pointer-events-none" style="line-height: 0; transform: translateY(-1px); z-index: 10;">
        <svg viewBox="0 0 1440 60" preserveAspectRatio="none" class="relative block w-full" style="height: 60px;">
            <path d="M0,0 L0,30 Q360,60 720,30 T1440,30 L1440,0 Z" fill="#ffffff"></path>
        </svg>
    </div> --}}

    <div class="relative pt-20 lg:pt-24 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Newsletter Section - REMOVED --}}
            {{-- Newsletter section has been removed as requested --}}

            {{-- Footer Grid (FR-13.1.3) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 mb-12">
                
                {{-- Column 1: Logo & Important Links (FR-13.2) --}}
                <div>
                    <a href="{{ route('home', [], false) }}" class="inline-block mb-6 flex items-center gap-3">
                        <img 
                            class="h-12 w-auto transition-all duration-300" 
                            src="{{ $logoUrl ?? asset('images/logo.svg') }}" 
                            alt="{{ $siteName }} Logo"
                            onerror="this.onerror=null; this.src='{{ asset('images/logo.svg') }}'"
                        >
                        <div>
                            <h2 class="text-xl font-bold leading-tight text-white">{{ $siteName }}</h2>
                            <p class="text-sm text-gray-300">Excellence in Education</p>
                        </div>
                    </a>
                    
                    {{-- Important Links (FR-13.2.2, FR-13.2.3) --}}
                    <h4 class="text-lg font-bold mb-4 uppercase tracking-wide" style="color: #fbbf24;">Important Links</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('about.index', [], false) }}" class="text-white/90 hover:text-yellow-300 transition-colors duration-200 block">About Us</a></li>
                        <li><a href="{{ route('academics.index', [], false) }}" class="text-white/90 hover:text-yellow-300 transition-colors duration-200 block">Academics</a></li>
                        <li><a href="{{ route('admission.index', [], false) }}" class="text-white/90 hover:text-yellow-300 transition-colors duration-200 block">Admissions</a></li>
                        <li><a href="{{ route('notices.index', [], false) }}" class="text-white/90 hover:text-yellow-300 transition-colors duration-200 block">News & Notices</a></li>
                        <li><a href="{{ route('contact.index', [], false) }}" class="text-white/90 hover:text-yellow-300 transition-colors duration-200 block">Contact Us</a></li>
                    </ul>
                </div>

                {{-- Column 3: Contact Info (FR-13.4) --}}
                <div>
                    <h4 class="text-lg font-bold mb-6 uppercase tracking-wide" style="color: #fbbf24;">Contact Info</h4>
                    <ul class="space-y-4">
                        @if($physicalAddress)
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-za-yellow-accent flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-white">{{ $physicalAddress }}</span>
                        </li>
                        @endif
                        
                        @if($primaryPhone)
                        <li class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-za-yellow-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $primaryPhone) }}" class="text-white hover:text-za-yellow-accent transition-colors">{{ $primaryPhone }}</a>
                        </li>
                        @endif
                        
                        @if($primaryEmail)
                        <li class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-za-yellow-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="mailto:{{ $primaryEmail }}" class="text-white hover:text-za-yellow-accent transition-colors">{{ $primaryEmail }}</a>
                        </li>
                        @endif
                    </ul>
                </div>

                {{-- Column 4: Newsletter (already implemented above) --}}
                {{-- Newsletter section is already rendered above the grid --}}

            </div>

            {{-- Bottom Bar --}}
            <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-400 text-center md:text-left">
                    @if($copyright)
                        {{ str_replace('{year}', date('Y'), $copyright) }}
                    @else
                        © {{ date('Y') }} {{ $siteName }}. All rights reserved.
                    @endif
                </p>
                
                <div class="flex gap-6 text-sm">
                    <a href="{{ route('privacy.show') }}" class="text-gray-400 hover:text-za-yellow-accent transition-colors">Privacy Policy</a>
                    <a href="{{ route('terms.show') }}" class="text-gray-400 hover:text-za-yellow-accent transition-colors">Terms of Service</a>
                    <a href="{{ route('sitemap') }}" class="text-gray-400 hover:text-za-yellow-accent transition-colors">Sitemap</a>
                </div>
            </div>

        </div>
    </div>

    {{-- Back to Top Button --}}
    <button
        x-data="{ show: false }"
        x-show="show"
        @scroll.window="show = window.pageYOffset > 300"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        x-transition
        class="fixed bottom-8 right-8 w-12 h-12 rounded-full shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-110 flex items-center justify-center z-40"
        style="background-color: #fbbf24; color: #008236; display: none;"
        aria-label="Back to top"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>
</footer>
