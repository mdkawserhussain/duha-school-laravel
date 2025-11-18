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
    
    // Get primary color from site settings
    $primaryColor = \App\Helpers\SiteSettingsHelper::primaryColor();
    // Ensure color format is correct (add # if missing)
    if (!str_starts_with($primaryColor, '#')) {
        $primaryColor = '#' . ltrim($primaryColor, '#');
    }
@endphp

@if($announcements->isNotEmpty())
<div class="announcement-bar text-white text-sm overflow-hidden" 
     id="announcement-bar" 
     style="position: fixed; top: 0; left: 0; right: 0; z-index: 60; width: 100%; margin: 0 !important; padding: 0.5rem 0 !important; background: rgba(255, 255, 255, 0.05) !important;"
     x-data="{ scrolled: false }"
     x-init="
         const announcementBar = $el;
         window.addEventListener('scroll', () => { 
             scrolled = window.pageYOffset > 50;
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
                                <span class="ml-2 font-semibold">{{ e($announcement->link_text ?? '') }}</span>
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

<!-- Main Navigation Bar -->
<header 
    class="fixed top-0 left-0 w-full transition-all duration-300"
    style="z-index: 9999 !important;"
    :style="{
        backgroundColor: (scrolled || !{{ request()->routeIs('home') ? 'true' : 'false' }}) ? '{{ $primaryColor }}' : 'rgba(255, 255, 255, 0.05)',
        boxShadow: scrolled ? '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)' : 'none'
    }"
    x-data="navbarData({{ $announcements->isNotEmpty() ? 'true' : 'false' }})"
        id="main-navbar">
    
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center justify-between h-20">
            <!-- Logo - Left -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center group transition-transform duration-200 hover:scale-105">
                    @php
                        $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
                        $siteName = \App\Helpers\SiteSettingsHelper::websiteName();
                        $settings = \App\Helpers\SiteSettingsHelper::all();
                        $cacheBuster = $settings->updated_at ? $settings->updated_at->timestamp : time();
                    @endphp
                    <img 
                        class="h-12 w-auto object-contain transition-transform duration-200 group-hover:rotate-3" 
                        src="{{ $logoUrl ?? asset('images/logo.svg') }}?v={{ $cacheBuster }}" 
                        alt="{{ $siteName }} Logo" 
                        onerror="this.onerror=null; this.src='{{ asset('images/logo.svg') }}?v={{ $cacheBuster }}'">
                </a>
            </div>
            
            <!-- Navigation Links - Right -->
            <div class="flex items-center space-x-6 md:space-x-8">
                <a href="{{ route('home') }}" 
                   class="relative text-sm font-medium transition-all duration-300 hover:text-white/90 group text-white">
                    <span class="relative">
                        Home
                        <span class="absolute bottom-0 left-0 h-0.5 bg-white transition-all duration-300 {{ request()->routeIs('home') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                    </span>
                </a>
                
                <!-- About Dropdown -->
                <div class="relative group" x-data="{ open: false }">
                    <button 
                        class="relative text-sm font-medium transition-all duration-300 hover:text-white/90 flex items-center text-white"
                        @mouseenter="open = true"
                        @mouseleave="open = false"
                        @click="open = !open"
                        aria-haspopup="true"
                        :aria-expanded="open">
                        <span>About</span>
                        <svg class="ml-1.5 h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full"></span>
                    </button>
                    <div 
                        class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-gray-100"
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        @mouseenter="open = true"
                        @mouseleave="open = false">
                        <a href="{{ route('about.show', 'principal') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-t-xl transition-colors duration-200">Principal's Message</a>
                        <a href="{{ route('about.show', 'vision') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-b-xl transition-colors duration-200">Vision & Mission</a>
                    </div>
                </div>
                
                <!-- Academics Dropdown -->
                <div class="relative group" x-data="{ open: false }">
                    <button 
                        class="relative text-sm font-medium transition-all duration-300 hover:text-white/90 flex items-center text-white"
                        @mouseenter="open = true"
                        @mouseleave="open = false"
                        @click="open = !open"
                        aria-haspopup="true"
                        :aria-expanded="open">
                        <span>Academics</span>
                        <svg class="ml-1.5 h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full"></span>
                    </button>
                    <div 
                        class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-gray-100"
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        @mouseenter="open = true"
                        @mouseleave="open = false">
                        <a href="{{ route('academic.show', 'curriculum') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-t-xl transition-colors duration-200">Curriculum</a>
                        <a href="{{ route('academic.show', 'policies') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-b-xl transition-colors duration-200">Policies</a>
                    </div>
                </div>
                
                <a href="{{ route('admission.index') }}" 
                   class="relative text-sm font-medium transition-all duration-300 hover:text-white/90 group text-white">
                    <span class="relative">
                        Admission
                        <span class="absolute bottom-0 left-0 h-0.5 bg-white transition-all duration-300 {{ request()->routeIs('admission.*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                    </span>
                </a>
                
                <!-- News & Media Dropdown -->
                <div class="relative group" x-data="{ open: false }">
                    <button 
                        class="relative text-sm font-medium transition-all duration-300 hover:text-white/90 flex items-center text-white"
                        @mouseenter="open = true"
                        @mouseleave="open = false"
                        @click="open = !open"
                        aria-haspopup="true"
                        :aria-expanded="open">
                        <span>News & Media</span>
                        <svg class="ml-1.5 h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full"></span>
                    </button>
                    <div 
                        class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-gray-100"
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        @mouseenter="open = true"
                        @mouseleave="open = false">
                        <a href="{{ route('events.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-t-xl transition-colors duration-200">Events</a>
                        <a href="{{ route('notices.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-b-xl transition-colors duration-200">Notices</a>
                    </div>
                </div>
                
                <a href="{{ route('careers.index') }}" 
                   class="relative text-sm font-medium transition-all duration-300 hover:text-white/90 group text-white">
                    <span class="relative">
                        Career
                        <span class="absolute bottom-0 left-0 h-0.5 bg-white transition-all duration-300 {{ request()->routeIs('careers.*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                    </span>
                </a>
                
                <a href="{{ route('contact.index') }}" 
                   class="relative text-sm font-medium transition-all duration-300 hover:text-white/90 group text-white">
                    <span class="relative">
                        Contact
                        <span class="absolute bottom-0 left-0 h-0.5 bg-white transition-all duration-300 {{ request()->routeIs('contact.*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                    </span>
                </a>
                
                <!-- Logout Button (only for authenticated users) -->
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button 
                            type="submit" 
                            class="relative text-sm font-medium transition-all duration-300 hover:text-white/90 text-white"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <span class="relative">
                                Logout
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-white transition-all duration-300 hover:w-full"></span>
                            </span>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
        
        <!-- Mobile Navigation -->
        <div class="lg:hidden flex items-center justify-between h-20 relative" style="z-index: 100001 !important;">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center">
                    @php
                        $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
                        $siteName = \App\Helpers\SiteSettingsHelper::websiteName();
                        $settings = \App\Helpers\SiteSettingsHelper::all();
                        $cacheBuster = $settings->updated_at ? $settings->updated_at->timestamp : time();
                    @endphp
                    <img 
                        class="h-10 w-auto object-contain" 
                        src="{{ $logoUrl ?? asset('images/logo.svg') }}?v={{ $cacheBuster }}" 
                        alt="{{ $siteName }} Logo" 
                        onerror="this.onerror=null; this.src='{{ asset('images/logo.svg') }}?v={{ $cacheBuster }}'">
                </a>
            </div>
            
            <!-- Hamburger Menu Button -->
            <button 
                type="button"
                class="inline-flex items-center justify-center p-2 rounded-lg text-white hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white/50 transition-colors duration-200 relative"
                @click="mobileMenuOpen = !mobileMenuOpen"
                :aria-expanded="mobileMenuOpen"
                aria-label="Toggle menu"
                style="pointer-events: auto; z-index: 100001 !important;">
                <svg class="h-6 w-6" :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg class="h-6 w-6" :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </nav>
    
    <!-- Mobile Menu Overlay -->
    <div 
        class="fixed inset-0 lg:hidden"
        style="z-index: 99999 !important;"
        x-show="mobileMenuOpen"
        x-cloak
        @keydown.escape.window="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
                <!-- Darkened backdrop to clearly separate the drawer from page content -->
                <div class="fixed inset-0 bg-black/60" style="z-index: 99999 !important;" @click="mobileMenuOpen = false"></div>
                <!-- Right-side drawer with strong contrast on all sections -->
                <div class="fixed inset-y-0 right-0 w-full max-w-sm bg-white shadow-2xl border-l border-gray-200 overflow-y-auto" style="z-index: 100000 !important;">
            <div class="flex flex-col h-full">
                <!-- Mobile Menu Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <a href="{{ route('home') }}" class="flex items-center" @click="mobileMenuOpen = false">
                        @php
                            $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
                            $siteName = \App\Helpers\SiteSettingsHelper::websiteName();
                            $settings = \App\Helpers\SiteSettingsHelper::all();
                            $cacheBuster = $settings->updated_at ? $settings->updated_at->timestamp : time();
                        @endphp
                        <img 
                            class="h-10 w-auto object-contain" 
                            src="{{ $logoUrl ?? asset('images/logo.svg') }}?v={{ $cacheBuster }}" 
                            alt="{{ $siteName }} Logo" 
                            onerror="this.onerror=null; this.src='{{ asset('images/logo.svg') }}?v={{ $cacheBuster }}'">
                    </a>
                    <button 
                        type="button"
                        class="p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-aisd-midnight transition-colors duration-200"
                        @click="mobileMenuOpen = false"
                        aria-label="Close menu">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <!-- Mobile Menu Content -->
                <nav class="flex-1 px-6 py-8 space-y-6">
                    <a href="{{ route('home') }}" 
                       class="block text-base font-medium text-gray-900 hover:text-aisd-midnight transition-colors duration-200 {{ request()->routeIs('home') ? 'text-aisd-midnight' : '' }}"
                       @click="mobileMenuOpen = false">Home</a>
                    
                    <!-- About Section -->
                    <div x-data="{ open: false }">
                        <button 
                            class="flex items-center justify-between w-full text-base font-medium text-gray-900 hover:text-aisd-midnight transition-colors duration-200"
                            @click="open = !open">
                            <span>About</span>
                            <svg class="h-5 w-5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="mt-2 space-y-2 pl-4">
                            <a href="{{ route('about.show', 'principal') }}" 
                               class="block text-sm text-gray-600 hover:text-aisd-midnight transition-colors duration-200"
                               @click="mobileMenuOpen = false">Principal's Message</a>
                            <a href="{{ route('about.show', 'vision') }}" 
                               class="block text-sm text-gray-600 hover:text-aisd-midnight transition-colors duration-200"
                               @click="mobileMenuOpen = false">Vision & Mission</a>
                        </div>
                    </div>
                    
                    <!-- Academics Section -->
                    <div x-data="{ open: false }">
                        <button 
                            class="flex items-center justify-between w-full text-base font-medium text-gray-900 hover:text-aisd-midnight transition-colors duration-200"
                            @click="open = !open">
                            <span>Academics</span>
                            <svg class="h-5 w-5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="mt-2 space-y-2 pl-4">
                            <a href="{{ route('academic.show', 'curriculum') }}" 
                               class="block text-sm text-gray-600 hover:text-aisd-midnight transition-colors duration-200"
                               @click="mobileMenuOpen = false">Curriculum</a>
                            <a href="{{ route('academic.show', 'policies') }}" 
                               class="block text-sm text-gray-600 hover:text-aisd-midnight transition-colors duration-200"
                               @click="mobileMenuOpen = false">Policies</a>
                        </div>
                    </div>
                    
                    <a href="{{ route('admission.index') }}" 
                       class="block text-base font-medium text-gray-900 hover:text-aisd-midnight transition-colors duration-200 {{ request()->routeIs('admission.*') ? 'text-aisd-midnight' : '' }}"
                       @click="mobileMenuOpen = false">Admission</a>
                    
                    <!-- News & Media Section -->
                    <div x-data="{ open: false }">
                        <button 
                            class="flex items-center justify-between w-full text-base font-medium text-gray-900 hover:text-aisd-midnight transition-colors duration-200"
                            @click="open = !open">
                            <span>News & Media</span>
                            <svg class="h-5 w-5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="mt-2 space-y-2 pl-4">
                            <a href="{{ route('events.index') }}" 
                               class="block text-sm text-gray-600 hover:text-aisd-midnight transition-colors duration-200"
                               @click="mobileMenuOpen = false">Events</a>
                            <a href="{{ route('notices.index') }}" 
                               class="block text-sm text-gray-600 hover:text-aisd-midnight transition-colors duration-200"
                               @click="mobileMenuOpen = false">Notices</a>
                        </div>
                    </div>
                    
                    <a href="{{ route('careers.index') }}" 
                       class="block text-base font-medium text-gray-900 hover:text-aisd-midnight transition-colors duration-200 {{ request()->routeIs('careers.*') ? 'text-aisd-midnight' : '' }}"
                       @click="mobileMenuOpen = false">Career</a>
                    
                    <a href="{{ route('contact.index') }}" 
                       class="block text-base font-medium text-gray-900 hover:text-aisd-midnight transition-colors duration-200 {{ request()->routeIs('contact.*') ? 'text-aisd-midnight' : '' }}"
                       @click="mobileMenuOpen = false">Contact</a>
                </nav>
                
                <!-- Mobile Menu Footer (Logout) -->
                @auth
                    <div class="px-6 py-6 border-t border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                        @csrf
                            <button 
                                type="submit" 
                                class="w-full text-left text-base font-medium text-gray-900 hover:text-aisd-midnight transition-colors duration-200"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </button>
                    </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>

<script>
function navbarData(hasAnnouncement) {
    return {
        scrolled: false,
        mobileMenuOpen: false,
        hasAnnouncement: hasAnnouncement,
        announcementHeight: 0,
        scrollPosition: 0,
        
        init() {
            const header = this.$el;
            const announcementBar = document.getElementById('announcement-bar');
            
            // Watch for mobile menu changes with better body lock
            this.$watch('mobileMenuOpen', (value) => {
                if (value) {
                    // Add class to body for CSS-based locking
                    document.documentElement.classList.add('menu-open');
                    document.body.classList.add('menu-open');
                } else {
                    // Remove class from body
                    document.documentElement.classList.remove('menu-open');
                    document.body.classList.remove('menu-open');
                }
            });
            
            if (announcementBar && this.hasAnnouncement) {
                const updateHeight = () => {
                    const actualHeight = announcementBar.offsetHeight;
                    this.announcementHeight = actualHeight;
                    if (!this.scrolled) {
                        header.style.setProperty('top', actualHeight + 'px', 'important');
                    }
                };
                
                requestAnimationFrame(() => {
                    updateHeight();
                    setTimeout(() => {
                        const computedTop = window.getComputedStyle(header).top;
                        const expectedTop = announcementBar.offsetHeight + 'px';
                        if (computedTop !== expectedTop) {
                            updateHeight();
                        }
                    }, 50);
                });
                
                const resizeObserver = new ResizeObserver(() => {
                    updateHeight();
                });
                resizeObserver.observe(announcementBar);
                
                window.addEventListener('scroll', () => {
                    this.scrolled = window.pageYOffset > 50;
                    if (this.scrolled) {
                        header.style.setProperty('top', '0', 'important');
                    } else {
                        updateHeight();
                    }
                });
            } else {
                header.style.setProperty('top', '0', 'important');
                window.addEventListener('scroll', () => {
                    this.scrolled = window.pageYOffset > 50;
                });
            }
            
            // Initial scroll check
            this.scrolled = window.pageYOffset > 50;
        }
    }
}
</script>
