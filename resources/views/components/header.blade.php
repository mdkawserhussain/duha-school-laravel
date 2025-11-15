<!-- Top Announcement Bar with Scrolling Text -->
@php
    // Completely disable announcements during exception rendering
    $announcements = collect([]);
    try {
        // Only load if we're absolutely sure we're not in an error context
        if (!app()->bound('exception') && 
            !str_contains(request()->path() ?? '', 'errors') &&
            !str_contains(request()->path() ?? '', '_dusk') &&
            !str_contains(request()->path() ?? '', 'telescope')) {
            $announcements = \App\Helpers\AnnouncementHelper::getSafe();
        }
    } catch (\Throwable $e) {
        // Silently fail - never break the page
        $announcements = collect([]);
    }
    
    // Debug logging
    \Log::info('Header Component Loaded', [
        'announcements_count' => $announcements->count(),
        'has_announcements' => $announcements->isNotEmpty(),
        'route' => request()->routeIs('home') ? 'home' : 'other',
    ]);
@endphp

@if($announcements->isNotEmpty())
<div class="announcement-bar gradient-indigo-violet text-white text-sm overflow-hidden" 
     id="announcement-bar" 
     style="position: fixed; top: 0; left: 0; right: 0; z-index: 60; width: 100%; margin: 0; padding: 0.5rem 0;"
     x-data="{ scrolled: false }"
     x-init="
         console.log('[ANNOUNCEMENT BAR] Initialized');
         const announcementBar = $el;
         console.log('[ANNOUNCEMENT BAR] Element:', announcementBar);
         console.log('[ANNOUNCEMENT BAR] Computed styles:', window.getComputedStyle(announcementBar));
         console.log('[ANNOUNCEMENT BAR] Height:', announcementBar.offsetHeight);
         console.log('[ANNOUNCEMENT BAR] Top:', announcementBar.offsetTop);
         window.addEventListener('scroll', () => { 
             scrolled = window.pageYOffset > 50;
             console.log('[ANNOUNCEMENT BAR] Scroll:', window.pageYOffset, 'Scrolled:', scrolled);
         });
     "
     :class="{ 'hidden': scrolled }"
     x-show="!scrolled"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div class="marquee-wrapper" style="overflow: hidden; width: 100%; position: relative;">
        <div class="marquee-content" style="display: inline-flex; white-space: nowrap; animation: marquee-scroll 20s linear infinite;">
            @foreach($announcements as $announcement)
                @if($announcement && !empty($announcement->message))
                <span style="padding-right: 3rem; display: inline-block;">
                    @if(!empty($announcement->link))
                        <a href="{{ e($announcement->link ?? '') }}" class="hover:underline" {{ empty($announcement->link_text) ? 'style="text-decoration: underline;"' : '' }}>
                            {{ e($announcement->message ?? '') }}
                            @if(!empty($announcement->link_text))
                                <span class="ml-2 font-semibold">{{ e($announcement->link_text ?? '') }} &rarr;</span>
                            @endif
                        </a>
                    @else
                        {{ e($announcement->message ?? '') }}
                    @endif
                </span>
                {{-- Repeat for seamless loop --}}
                <span style="padding-right: 3rem; display: inline-block;">
                    @if(!empty($announcement->link))
                        <a href="{{ e($announcement->link ?? '') }}" class="hover:underline" {{ empty($announcement->link_text) ? 'style="text-decoration: underline;"' : '' }}>
                            {{ e($announcement->message ?? '') }}
                            @if(!empty($announcement->link_text))
                                <span class="ml-2 font-semibold">{{ e($announcement->link_text ?? '') }} &rarr;</span>
                            @endif
                        </a>
                    @else
                        {{ e($announcement->message ?? '') }}
                    @endif
                </span>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endif

<style>
@keyframes marquee-scroll {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}
</style>

<header class="sticky z-40 border-b transition-all duration-300 {{ request()->routeIs('home') ? 'navbar-transparent' : 'bg-white shadow-md' }} {{ $announcements->isNotEmpty() ? 'header-with-announcement' : 'top-0' }}" 
        style="position: sticky; top: 0; margin: 0 !important; padding: 0 !important;"
        x-data="{ scrolled: false, hasAnnouncement: {{ $announcements->isNotEmpty() ? 'true' : 'false' }}, announcementHeight: 0 }" 
        x-init="
            console.log('[HEADER] Initialized');
            console.log('[HEADER] Has announcement:', hasAnnouncement);
            const header = $el;
            
            // Get actual announcement bar height dynamically
            const announcementBar = document.getElementById('announcement-bar');
            if (announcementBar && hasAnnouncement) {
                // Use ResizeObserver to track actual height changes
                const updateHeight = () => {
                    const actualHeight = announcementBar.offsetHeight;
                    announcementHeight = actualHeight;
                    if (!scrolled) {
                        // Use setProperty with important flag to override CSS
                        header.style.setProperty('top', actualHeight + 'px', 'important');
                        console.log('[HEADER] Set top to actual announcement height:', actualHeight + 'px');
                        console.log('[HEADER] Computed top after setting:', window.getComputedStyle(header).top);
                    }
                };
                
                // Initial measurement - use requestAnimationFrame to ensure DOM is ready
                requestAnimationFrame(() => {
                    updateHeight();
                    // Double-check after a short delay
                    setTimeout(() => {
                        const computedTop = window.getComputedStyle(header).top;
                        const expectedTop = announcementBar.offsetHeight + 'px';
                        if (computedTop !== expectedTop) {
                            console.warn('[HEADER] Top mismatch! Expected:', expectedTop, 'Got:', computedTop);
                            updateHeight();
                        }
                    }, 50);
                });
                
                // Watch for size changes
                const resizeObserver = new ResizeObserver(() => {
                    updateHeight();
                });
                resizeObserver.observe(announcementBar);
                
                // Also check on scroll to handle visibility changes
                window.addEventListener('scroll', () => {
                    scrolled = window.pageYOffset > 50;
                    if (scrolled) {
                        header.style.setProperty('top', '0', 'important');
                        console.log('[HEADER] Scrolled - top set to 0');
                    } else {
                        updateHeight();
                    }
                });
            } else {
                // No announcement bar, header at top
                header.style.setProperty('top', '0', 'important');
                window.addEventListener('scroll', () => {
                    scrolled = window.pageYOffset > 50;
                });
            }
            
            console.log('[HEADER] Setup complete');
        " 
        :class="{ 
            'shadow-xl bg-white text-gray-900': scrolled, 
            'navbar-transparent text-white': !scrolled && {{ request()->routeIs('home') ? 'true' : 'false' }},
            'bg-white text-gray-900': !scrolled && !{{ request()->routeIs('home') ? 'true' : 'false' }}
        }"
        id="main-navbar">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="margin: 0; padding-top: 0; padding-bottom: 0;">
        <div class="flex items-center h-20" style="margin: 0; padding: 0;">
            <!-- Logo - Left -->
            <div class="flex-shrink-0" style="margin: 0; padding: 0;">
                <a href="{{ route('home') }}" class="flex items-center group transition-transform duration-200 hover:scale-105">
                    @php
                        $logoUrl = \App\Models\SiteSettings::getLogoUrl();
                        $siteName = \App\Helpers\SiteHelper::getSiteName();
                    @endphp
                    <img class="h-12 w-auto transition-transform duration-200 group-hover:rotate-3" src="{{ $logoUrl }}" alt="{{ $siteName }} Logo" onerror="this.onerror=null; this.src='{{ asset('images/logo.svg') }}'">
                </a>
            </div>
            
            <!-- Desktop Navigation - Center -->
            <div class="hidden lg:flex flex-1 justify-center items-center" style="margin: 0; padding: 0;">
                <div class="flex items-center space-x-1" style="margin: 0; padding: 0;">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200" 
                       :class="scrolled ? 'text-gray-900 hover:bg-gray-100' : ({{ request()->routeIs('home') ? 'true' : 'false' }} ? 'text-white hover:bg-white/20' : 'text-gray-900 hover:bg-gray-100')"
                       :class="{{ request()->routeIs('home') ? '(scrolled ? \'bg-gray-100 text-gray-900\' : \'bg-white/20 text-white\')' : '' }}">Home</a>
                    
                    <!-- About Dropdown -->
                    <div class="relative group">
                        <button class="px-4 py-2 rounded-lg text-sm font-medium flex items-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2" 
                                :class="scrolled ? 'text-gray-900 hover:bg-gray-100 focus:ring-gray-500' : ({{ request()->routeIs('home') ? 'true' : 'false' }} ? 'text-white hover:bg-white/20 focus:ring-white/50' : 'text-gray-900 hover:bg-gray-100 focus:ring-gray-500')"
                                aria-haspopup="true" aria-expanded="false">
                            About
                            <svg class="ml-2 h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-gray-100">
                            <a href="{{ route('about.show', 'principal') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-t-xl transition-colors duration-200 first:rounded-t-xl">Principal's Message</a>
                            <a href="{{ route('about.show', 'vision') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-b-xl transition-colors duration-200 last:rounded-b-xl">Vision & Mission</a>
                        </div>
                    </div>
                    
                    <!-- Academics Dropdown -->
                    <div class="relative group">
                        <button class="px-4 py-2 rounded-lg text-sm font-medium flex items-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2" 
                                :class="scrolled ? 'text-gray-900 hover:bg-gray-100 focus:ring-gray-500' : ({{ request()->routeIs('home') ? 'true' : 'false' }} ? 'text-white hover:bg-white/20 focus:ring-white/50' : 'text-gray-900 hover:bg-gray-100 focus:ring-gray-500')"
                                aria-haspopup="true" aria-expanded="false">
                            Academics
                            <svg class="ml-2 h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-gray-100">
                            <a href="{{ route('academic.show', 'curriculum') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-t-xl transition-colors duration-200 first:rounded-t-xl">Curriculum</a>
                            <a href="{{ route('academic.show', 'policies') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-b-xl transition-colors duration-200 last:rounded-b-xl">Policies</a>
                        </div>
                    </div>
                    
                    <a href="{{ route('admission.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200" 
                       :class="scrolled ? 'text-gray-900 hover:bg-gray-100' : ({{ request()->routeIs('home') ? 'true' : 'false' }} ? 'text-white hover:bg-white/20' : 'text-gray-900 hover:bg-gray-100')"
                       :class="{{ request()->routeIs('admission.*') ? '(scrolled ? \'bg-gray-100 text-gray-900\' : \'bg-white/20 text-white\')' : '' }}">Admission</a>
                    
                    <!-- News & Media Dropdown -->
                    <div class="relative group">
                        <button class="px-4 py-2 rounded-lg text-sm font-medium flex items-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2" 
                                :class="scrolled ? 'text-gray-900 hover:bg-gray-100 focus:ring-gray-500' : ({{ request()->routeIs('home') ? 'true' : 'false' }} ? 'text-white hover:bg-white/20 focus:ring-white/50' : 'text-gray-900 hover:bg-gray-100 focus:ring-gray-500')"
                                aria-haspopup="true" aria-expanded="false">
                            News & Media
                            <svg class="ml-2 h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-gray-100">
                            <a href="{{ route('events.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-t-xl transition-colors duration-200">Events</a>
                            <a href="{{ route('notices.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-b-xl transition-colors duration-200">Notices</a>
                        </div>
                    </div>
                    
                    <a href="{{ route('careers.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200" 
                       :class="scrolled ? 'text-gray-900 hover:bg-gray-100' : ({{ request()->routeIs('home') ? 'true' : 'false' }} ? 'text-white hover:bg-white/20' : 'text-gray-900 hover:bg-gray-100')"
                       :class="{{ request()->routeIs('careers.*') ? '(scrolled ? \'bg-gray-100 text-gray-900\' : \'bg-white/20 text-white\')' : '' }}">Career</a>
                    <a href="{{ route('contact.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200" 
                       :class="scrolled ? 'text-gray-900 hover:bg-gray-100' : ({{ request()->routeIs('home') ? 'true' : 'false' }} ? 'text-white hover:bg-white/20' : 'text-gray-900 hover:bg-gray-100')"
                       :class="{{ request()->routeIs('contact.*') ? '(scrolled ? \'bg-gray-100 text-gray-900\' : \'bg-white/20 text-white\')' : '' }}">Contact</a>
                    
                </div>
            </div>
            
            <!-- Right Side - Search and Login -->
            <div class="hidden lg:flex items-center space-x-2 ml-auto" style="margin: 0; padding: 0;">
                <!-- Search Button -->
                <button onclick="openSearchModal()" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200" 
                        :class="scrolled ? 'text-gray-900 hover:bg-gray-100' : ({{ request()->routeIs('home') ? 'true' : 'false' }} ? 'text-white hover:bg-white/20' : 'text-gray-900 hover:bg-gray-100')"
                        aria-label="Search">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                
                <!-- Language Switcher -->
                <x-language-switcher />
                
                @auth
                    <a href="{{ url('/admin') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200" 
                       :class="scrolled ? 'text-gray-900 hover:bg-gray-100' : ({{ request()->routeIs('home') ? 'true' : 'false' }} ? 'text-white hover:bg-white/20' : 'text-gray-900 hover:bg-gray-100')">Admin</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200" 
                                :class="scrolled ? 'text-gray-900 hover:bg-gray-100' : ({{ request()->routeIs('home') ? 'true' : 'false' }} ? 'text-white hover:bg-white/20' : 'text-gray-900 hover:bg-gray-100')">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200" 
                       :class="scrolled ? 'text-gray-900 hover:bg-gray-100' : ({{ request()->routeIs('home') ? 'true' : 'false' }} ? 'text-white hover:bg-white/20' : 'text-gray-900 hover:bg-gray-100')">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">Register</a>
                    @endif
                @endauth
            </div>
            
            <!-- Mobile menu button -->
            <div class="lg:hidden" style="margin: 0; padding: 0;">
                <button type="button" id="mobile-menu-button" class="bg-blue-100 inline-flex items-center justify-center p-3 rounded-xl text-blue-600 hover:text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200" aria-controls="mobile-menu" aria-expanded="false" onclick="toggleMobileMenu()">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>
    
    <!-- Mobile menu -->
    <div class="lg:hidden hidden" id="mobile-menu">
        <div class="px-4 pt-4 pb-6 space-y-2 bg-gradient-to-b from-blue-50 to-white border-t border-blue-100 shadow-inner">
            <a href="{{ route('home') }}" class="text-blue-900 hover:text-white hover:bg-blue-600 block px-4 py-3 rounded-lg text-base font-medium transition-all duration-200 {{ request()->routeIs('home') ? 'bg-blue-600 text-white' : '' }}">Home</a>
            
            <!-- Mobile About Menu -->
            <div class="space-y-1">
                <div class="px-4 py-2 text-sm font-semibold text-blue-700 uppercase tracking-wide">About</div>
                <a href="{{ route('about.show', 'principal') }}" class="block px-6 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-colors duration-200">Principal's Message</a>
                <a href="{{ route('about.show', 'vision') }}" class="block px-6 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-colors duration-200">Vision & Mission</a>
            </div>
            
            <!-- Mobile Academics Menu -->
            <div class="space-y-1">
                <div class="px-4 py-2 text-sm font-semibold text-blue-700 uppercase tracking-wide">Academics</div>
                <a href="{{ route('academic.show', 'curriculum') }}" class="block px-6 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-colors duration-200">Curriculum</a>
                <a href="{{ route('academic.show', 'policies') }}" class="block px-6 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-colors duration-200">Policies</a>
            </div>
            
            <a href="{{ route('admission.index') }}" class="text-blue-900 hover:text-white hover:bg-blue-600 block px-4 py-3 rounded-lg text-base font-medium transition-all duration-200 {{ request()->routeIs('admission.*') ? 'bg-blue-600 text-white' : '' }}">Admission</a>
            
            <!-- Mobile News & Media Menu -->
            <div class="space-y-1">
                <div class="px-4 py-2 text-sm font-semibold text-blue-700 uppercase tracking-wide">News & Media</div>
                <a href="{{ route('events.index') }}" class="block px-6 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-colors duration-200">Events</a>
                <a href="{{ route('notices.index') }}" class="block px-6 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-colors duration-200">Notices</a>
            </div>
            
            <a href="{{ route('careers.index') }}" class="text-blue-900 hover:text-white hover:bg-blue-600 block px-4 py-3 rounded-lg text-base font-medium transition-all duration-200 {{ request()->routeIs('careers.*') ? 'bg-blue-600 text-white' : '' }}">Career</a>
            <a href="{{ route('contact.index') }}" class="text-blue-900 hover:text-white hover:bg-blue-600 block px-4 py-3 rounded-lg text-base font-medium transition-all duration-200 {{ request()->routeIs('contact.*') ? 'bg-blue-600 text-white' : '' }}">Contact</a>
            
            <!-- Mobile Language Switcher -->
            <div class="px-4 py-3">
                <x-language-switcher class="w-full" />
            </div>
            
            <!-- Mobile Search -->
            <button onclick="openSearchModal()" class="text-blue-900 hover:text-white hover:bg-blue-600 block px-4 py-3 rounded-lg text-base font-medium transition-all duration-200 w-full text-left">
                <span class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </span>
            </button>
            
            @auth
                <a href="{{ url('/admin') }}" class="text-blue-900 hover:text-white hover:bg-blue-600 block px-4 py-3 rounded-lg text-base font-medium transition-all duration-200">Admin</a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left text-blue-900 hover:text-white hover:bg-blue-600 px-4 py-3 rounded-lg text-base font-medium transition-all duration-200">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-blue-900 hover:text-white hover:bg-blue-600 block px-4 py-3 rounded-lg text-base font-medium transition-all duration-200">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white block px-4 py-3 rounded-lg text-base font-medium transition-all duration-200">Register</a>
                @endif
            @endauth
        </div>
    </div>
</header>

<script>
// Debug layout on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('[LAYOUT DEBUG] DOM Content Loaded');
    
    const announcementBar = document.getElementById('announcement-bar');
    const header = document.getElementById('main-navbar');
    const heroSection = document.querySelector('.hero-section');
    const main = document.querySelector('main');
    
    function debugLayout() {
        console.log('=== LAYOUT DEBUG ===');
        
        if (announcementBar) {
            const abRect = announcementBar.getBoundingClientRect();
            console.log('[ANNOUNCEMENT BAR]');
            console.log('  - Display:', window.getComputedStyle(announcementBar).display);
            console.log('  - Position:', window.getComputedStyle(announcementBar).position);
            console.log('  - Top:', abRect.top, 'px');
            console.log('  - Height:', abRect.height, 'px');
            console.log('  - Bottom:', abRect.bottom, 'px');
            console.log('  - Margin:', window.getComputedStyle(announcementBar).margin);
            console.log('  - Padding:', window.getComputedStyle(announcementBar).padding);
        } else {
            console.log('[ANNOUNCEMENT BAR] Not found');
        }
        
        if (header) {
            const hRect = header.getBoundingClientRect();
            console.log('[HEADER]');
            console.log('  - Position:', window.getComputedStyle(header).position);
            console.log('  - Top:', hRect.top, 'px');
            console.log('  - Height:', hRect.height, 'px');
            console.log('  - Bottom:', hRect.bottom, 'px');
            console.log('  - Margin:', window.getComputedStyle(header).margin);
            console.log('  - Padding:', window.getComputedStyle(header).padding);
            
            if (announcementBar) {
                const abRect = announcementBar.getBoundingClientRect();
                const gap = hRect.top - abRect.bottom;
                console.log('  - Gap from announcement bar:', gap, 'px');
                if (gap > 0) {
                    console.error('  - ⚠️ GAP DETECTED:', gap, 'px');
                }
            }
        } else {
            console.log('[HEADER] Not found');
        }
        
        if (heroSection) {
            const hsRect = heroSection.getBoundingClientRect();
            console.log('[HERO SECTION]');
            console.log('  - Top:', hsRect.top, 'px');
            console.log('  - Height:', hsRect.height, 'px');
            console.log('  - Margin:', window.getComputedStyle(heroSection).margin);
            console.log('  - Padding:', window.getComputedStyle(heroSection).padding);
            
            if (header) {
                const hRect = header.getBoundingClientRect();
                const gap = hsRect.top - hRect.bottom;
                console.log('  - Gap from header:', gap, 'px');
                if (gap > 0) {
                    console.error('  - ⚠️ GAP DETECTED:', gap, 'px');
                }
            }
        } else {
            console.log('[HERO SECTION] Not found');
        }
        
        if (main) {
            const mRect = main.getBoundingClientRect();
            console.log('[MAIN]');
            console.log('  - Top:', mRect.top, 'px');
            console.log('  - Margin:', window.getComputedStyle(main).margin);
            console.log('  - Padding:', window.getComputedStyle(main).padding);
        }
        
        console.log('=== END LAYOUT DEBUG ===');
    }
    
    // Debug immediately
    debugLayout();
    
    // Debug after a short delay
    setTimeout(debugLayout, 100);
    setTimeout(debugLayout, 500);
    setTimeout(debugLayout, 1000);
    
    // Debug on scroll
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(debugLayout, 100);
    });
    
    // Debug on resize
    window.addEventListener('resize', function() {
        setTimeout(debugLayout, 100);
    });
});

function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    const button = document.getElementById('mobile-menu-button');
    const isExpanded = button.getAttribute('aria-expanded') === 'true';

    menu.classList.toggle('hidden');
    button.setAttribute('aria-expanded', !isExpanded);

    // Update button icon
    const icon = button.querySelector('svg');
    if (isExpanded) {
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
    } else {
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
    }
}

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const menu = document.getElementById('mobile-menu');
    const button = document.getElementById('mobile-menu-button');

    if (!menu.contains(event.target) && !button.contains(event.target)) {
        menu.classList.add('hidden');
        button.setAttribute('aria-expanded', 'false');
        const icon = button.querySelector('svg');
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
    }
});

// Close mobile menu on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const menu = document.getElementById('mobile-menu');
        const button = document.getElementById('mobile-menu-button');

        menu.classList.add('hidden');
        button.setAttribute('aria-expanded', 'false');
        const icon = button.querySelector('svg');
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
    }
});

// Search Modal
function openSearchModal() {
    const modal = document.getElementById('search-modal');
    if (modal) {
        modal.classList.add('open');
        modal.classList.remove('hidden');
        const input = document.getElementById('search-input');
        if (input) input.focus();
    }
}

function closeSearchModal() {
    const modal = document.getElementById('search-modal');
    if (modal) {
        modal.classList.remove('open');
        modal.classList.add('hidden');
    }
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeSearchModal();
    }
});

document.addEventListener('click', function(event) {
    const modal = document.getElementById('search-modal');
    if (!modal) return;
    if (!modal.classList.contains('open')) return;
    const content = modal.querySelector('.search-modal-content');
    if (content && !content.contains(event.target)) {
        closeSearchModal();
    }
});
</script>

<!-- Search Modal -->
<div id="search-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-start justify-center pt-20 px-4">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full p-6 relative">
        <button onclick="closeSearchModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition duration-300">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Search</h2>
        
        <form action="{{ route('search') }}" method="GET" class="mb-4">
            <div class="flex gap-2">
                <input 
                    type="text" 
                    name="q" 
                    id="search-input"
                    value="{{ request('q') }}" 
                    placeholder="Search events, notices, pages..." 
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required
                    autocomplete="off"
                >
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                    Search
                </button>
            </div>
        </form>
        
        <div class="text-sm text-gray-600">
            <p>Search across events, notices, and pages</p>
        </div>
    </div>
</div>
