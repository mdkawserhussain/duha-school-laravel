<!-- Top Announcement Bar with Scrolling Text -->
<div class="gradient-indigo-violet text-white py-2 text-sm overflow-hidden relative">
    <div class="marquee-wrapper">
        <div class="marquee-content">
            <span>Admission ongoing on Al-Maghrib International School. Visit our campus to know more.</span>
            <span>Admission ongoing on Al-Maghrib International School. Visit our campus to know more.</span>
            <span>Admission ongoing on Al-Maghrib International School. Visit our campus to know more.</span>
        </div>
    </div>
</div>

<style>
.marquee-wrapper {
    overflow: hidden;
    width: 100%;
    position: relative;
}

.marquee-content {
    display: inline-flex;
    white-space: nowrap;
    animation: marquee-scroll 20s linear infinite;
}

.marquee-content span {
    padding-right: 3rem;
    display: inline-block;
}

@keyframes marquee-scroll {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}
</style>

<header class="bg-white shadow-md sticky top-0 z-40 border-b border-indigo-100 transition-all duration-300" x-data="{ scrolled: false }" x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 50; })" :class="{ 'shadow-xl': scrolled }">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center h-20">
            <!-- Logo - Left -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center group transition-transform duration-200 hover:scale-105">
                    @php
                        $logoUrl = \App\Models\SiteSettings::getLogoUrl();
                    @endphp
                    <img class="h-12 w-auto transition-transform duration-200 group-hover:rotate-3" src="{{ $logoUrl }}" alt="AlMaghrib International School Logo" onerror="this.onerror=null; this.src='{{ asset('images/logo.svg') }}'">
                </a>
            </div>

            <!-- Desktop Navigation - Center -->
            <div class="hidden lg:flex flex-1 justify-center items-center">
                <div class="flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="text-blue-900 hover:text-white hover:bg-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('home') ? 'bg-blue-600 text-white' : '' }}">Home</a>

                    <!-- About Dropdown -->
                    <div class="relative group">
                        <button class="text-blue-900 hover:text-white hover:bg-blue-600 px-4 py-2 rounded-lg text-sm font-medium flex items-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" aria-haspopup="true" aria-expanded="false">
                            About
                            <svg class="ml-2 h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-blue-100">
                            <a href="{{ route('about.show', 'principal') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-t-xl transition-colors duration-200 first:rounded-t-xl">Principal's Message</a>
                            <a href="{{ route('about.show', 'vision') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-b-xl transition-colors duration-200 last:rounded-b-xl">Vision & Mission</a>
                        </div>
                    </div>

                    <!-- Academics Dropdown -->
                    <div class="relative group">
                        <button class="text-blue-900 hover:text-white hover:bg-blue-600 px-4 py-2 rounded-lg text-sm font-medium flex items-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" aria-haspopup="true" aria-expanded="false">
                            Academics
                            <svg class="ml-2 h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-blue-100">
                            <a href="{{ route('academic.show', 'curriculum') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-t-xl transition-colors duration-200 first:rounded-t-xl">Curriculum</a>
                            <a href="{{ route('academic.show', 'policies') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-b-xl transition-colors duration-200 last:rounded-b-xl">Policies</a>
                        </div>
                    </div>

                    <a href="{{ route('admission.index') }}" class="text-blue-900 hover:text-white hover:bg-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admission.*') ? 'bg-blue-600 text-white' : '' }}">Admission</a>
                    
                    <!-- News & Media Dropdown -->
                    <div class="relative group">
                        <button class="text-blue-900 hover:text-white hover:bg-blue-600 px-4 py-2 rounded-lg text-sm font-medium flex items-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" aria-haspopup="true" aria-expanded="false">
                            News & Media
                            <svg class="ml-2 h-4 w-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-blue-100">
                            <a href="{{ route('events.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-t-xl transition-colors duration-200">Events</a>
                            <a href="{{ route('notices.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-b-xl transition-colors duration-200">Notices</a>
                        </div>
                    </div>
                    
                    <a href="{{ route('careers.index') }}" class="text-blue-900 hover:text-white hover:bg-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('careers.*') ? 'bg-blue-600 text-white' : '' }}">Career</a>
                    <a href="{{ route('contact.index') }}" class="text-blue-900 hover:text-white hover:bg-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('contact.*') ? 'bg-blue-600 text-white' : '' }}">Contact</a>
                    
                </div>
            </div>

            <!-- Right Side - Search and Login -->
            <div class="hidden lg:flex items-center space-x-2 ml-auto">
                <!-- Search Button -->
                <button onclick="openSearchModal()" class="text-blue-900 hover:text-white hover:bg-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200" aria-label="Search">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                
                <!-- Language Switcher -->
                <x-language-switcher />
                
                @auth
                    <a href="{{ url('/admin') }}" class="text-blue-900 hover:text-white hover:bg-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">Admin</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-blue-900 hover:text-white hover:bg-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-blue-900 hover:text-white hover:bg-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">Register</a>
                    @endif
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="lg:hidden">
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