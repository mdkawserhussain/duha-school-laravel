@php
    $currentRoute = request()->route()->getName();
    $user = auth()->user();
@endphp

<!-- Sidebar -->
<aside 
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0"
    :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }"
    x-show="sidebarOpen || window.innerWidth >= 1024"
    @click.away="if (window.innerWidth < 1024) sidebarOpen = false"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
>
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
            <div class="flex items-center">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span class="ml-2 text-lg font-bold text-gray-900">{{ \App\Helpers\SiteSettingsHelper::websiteName() }}</span>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 overflow-y-auto">
            <div class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors {{ str_starts_with($currentRoute, 'admin.dashboard') ? 'bg-green-600 text-white shadow-md' : 'text-gray-900 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                
                @if($user->hasAnyRole(['admin', 'editor']))
                    <!-- Content Section -->
                    <div class="pt-4">
                        <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Content</p>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('admin.events.index') }}" 
                               class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors {{ str_starts_with($currentRoute, 'admin.events') ? 'bg-green-600 text-white shadow-md' : 'text-gray-900 hover:bg-gray-100 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Events
                            </a>
                            
                            <a href="{{ route('admin.notices.index') }}" 
                               class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors {{ str_starts_with($currentRoute, 'admin.notices') ? 'bg-green-600 text-white shadow-md' : 'text-gray-900 hover:bg-gray-100 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                </svg>
                                Notices
                            </a>
                            
                            <a href="{{ route('admin.pages.index') }}" 
                               class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors {{ str_starts_with($currentRoute, 'admin.pages') ? 'bg-green-600 text-white shadow-md' : 'text-gray-900 hover:bg-gray-100 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Pages
                            </a>
                            
                            <a href="{{ route('admin.staff.index') }}" 
                               class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors {{ str_starts_with($currentRoute, 'admin.staff') ? 'bg-green-600 text-white shadow-md' : 'text-gray-900 hover:bg-gray-100 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Staff
                            </a>
                        </div>
                    </div>
                    
                    <!-- Homepage Settings -->
                    <div class="pt-4">
                        <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Homepage</p>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('admin.hero-slider.index') }}" 
                               class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors {{ str_starts_with($currentRoute, 'admin.hero-slider') ? 'bg-green-600 text-white shadow-md' : 'text-gray-900 hover:bg-gray-100 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Hero Slider
                            </a>
                            
                            <a href="{{ route('admin.homepage-sections.index') }}" 
                               class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors {{ str_starts_with($currentRoute, 'admin.homepage-sections') ? 'bg-green-600 text-white shadow-md' : 'text-gray-900 hover:bg-gray-100 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                                </svg>
                                Sections
                            </a>
                            
                            <a href="{{ route('admin.homepage-contents.index') }}" 
                               class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors {{ str_starts_with($currentRoute, 'admin.homepage-contents') ? 'bg-green-600 text-white shadow-md' : 'text-gray-900 hover:bg-gray-100 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Contents
                            </a>
                        </div>
                    </div>
                    
                    <!-- Settings -->
                    <div class="pt-4">
                        <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Settings</p>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('admin.settings.edit') }}" 
                               class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors {{ str_starts_with($currentRoute, 'admin.settings') ? 'bg-green-600 text-white shadow-md' : 'text-gray-900 hover:bg-gray-100 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Site Settings
                            </a>
                            
                            <a href="{{ route('admin.navigation-items.index') }}" 
                               class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors {{ str_starts_with($currentRoute, 'admin.navigation-items') ? 'bg-green-600 text-white shadow-md' : 'text-gray-900 hover:bg-gray-100 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                                Navigation
                            </a>
                            
                            <a href="{{ route('admin.announcements.index') }}" 
                               class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors {{ str_starts_with($currentRoute, 'admin.announcements') ? 'bg-green-600 text-white shadow-md' : 'text-gray-900 hover:bg-gray-100 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                </svg>
                                Announcements
                            </a>
                        </div>
                    </div>
                @endif
                
                @if($user->hasAnyRole(['admin', 'admissions_officer']))
                    <!-- Applications -->
                    <div class="pt-4">
                        <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Applications</p>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('admin.admission-applications.index') }}" 
                               class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors {{ str_starts_with($currentRoute, 'admin.admission-applications') ? 'bg-green-600 text-white shadow-md' : 'text-gray-900 hover:bg-gray-100 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Admissions
                            </a>
                            
                            <a href="{{ route('admin.career-applications.index') }}" 
                               class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-colors {{ str_starts_with($currentRoute, 'admin.career-applications') ? 'bg-green-600 text-white shadow-md' : 'text-gray-900 hover:bg-gray-100 hover:text-gray-900' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Careers
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </nav>
        
        <!-- User Info -->
        <div class="p-4 border-t border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center text-white font-semibold shadow-md">
                        {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                    </div>
                </div>
                <div class="ml-3 flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Sidebar Overlay (Mobile) -->
<div 
    x-show="sidebarOpen && window.innerWidth < 1024"
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden"
    @click="sidebarOpen = false"
    style="display: none;"
></div>

