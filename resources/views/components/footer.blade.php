<footer class="relative" style="background-color: #1e3a5f; color: #ffffff;">
    <!-- Curved Wave at Top -->
    <div class="absolute top-0 left-0 w-full overflow-hidden" style="line-height: 0;">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" style="position: relative; display: block; width: 100%; height: 100px;">
            <path d="M0,0 C480,120 960,120 1440,0 L1440,120 L0,120 Z" style="fill: #1e3a5f;"></path>
        </svg>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16" style="padding-top: 5rem; padding-bottom: 3rem;">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 sm:gap-10 lg:gap-12">
            <!-- Contact Us -->
            <div class="mb-8 sm:mb-0">
                <h3 class="text-lg sm:text-xl font-bold mb-4 sm:mb-6" style="color: #F4C430;">Contact Us</h3>
                <div class="space-y-3 sm:space-y-4">
                    @php
                        $physicalAddress = \App\Helpers\SiteSettingsHelper::physicalAddress();
                        $primaryPhone = \App\Helpers\SiteSettingsHelper::primaryPhone();
                        $primaryEmail = \App\Helpers\SiteSettingsHelper::primaryEmail();
                        $businessHours = \App\Helpers\SiteSettingsHelper::businessHours();
                    @endphp
                    @if($physicalAddress)
                    <div>
                        <p class="mb-1" style="color: rgba(255, 255, 255, 0.95);">{{ $physicalAddress }}</p>
                    </div>
                    @endif
                    @if($primaryPhone)
                    <div>
                        <p class="mb-1" style="color: rgba(255, 255, 255, 0.95);">
                            <a href="tel:{{ $primaryPhone }}" style="color: rgba(255, 255, 255, 0.95); text-decoration: none;">{{ $primaryPhone }}</a>
                        </p>
                    </div>
                    @endif
                    @if($primaryEmail)
                    <div>
                        <p style="color: rgba(255, 255, 255, 0.95);">
                            <a href="mailto:{{ $primaryEmail }}" style="color: rgba(255, 255, 255, 0.95); text-decoration: none;">{{ $primaryEmail }}</a>
                        </p>
                    </div>
                    @endif
                    @if($businessHours)
                    <div>
                        <p class="mt-2" style="color: rgba(255, 255, 255, 0.85); font-size: 0.9rem;">{!! nl2br(e($businessHours)) !!}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div class="mb-8 sm:mb-0">
                <h3 class="text-lg sm:text-xl font-bold mb-4 sm:mb-6" style="color: #F4C430;">Quick Links</h3>
                <ul class="space-y-2 sm:space-y-3">
                    <li><a href="{{ route('academic.show', 'curriculum') }}" class="transition-colors duration-300 block py-2 min-h-[44px] flex items-center" style="color: rgba(255, 255, 255, 0.95);" onmouseover="this.style.color='#F4C430'" onmouseout="this.style.color='rgba(255, 255, 255, 0.95)'">Academics</a></li>
                    <li><a href="{{ route('admission.index') }}" class="transition-colors duration-300 block py-2 min-h-[44px] flex items-center" style="color: rgba(255, 255, 255, 0.95);" onmouseover="this.style.color='#F4C430'" onmouseout="this.style.color='rgba(255, 255, 255, 0.95)'">Admission</a></li>
                    <li><a href="{{ route('events.index') }}" class="transition-colors duration-300 block py-2 min-h-[44px] flex items-center" style="color: rgba(255, 255, 255, 0.95);" onmouseover="this.style.color='#F4C430'" onmouseout="this.style.color='rgba(255, 255, 255, 0.95)'">News and Events</a></li>
                    <li><a href="{{ route('careers.index') }}" class="transition-colors duration-300 block py-2 min-h-[44px] flex items-center" style="color: rgba(255, 255, 255, 0.95);" onmouseover="this.style.color='#F4C430'" onmouseout="this.style.color='rgba(255, 255, 255, 0.95)'">Career</a></li>
                    <li><a href="{{ route('campus.show') }}" class="transition-colors duration-300 block py-2 min-h-[44px] flex items-center" style="color: rgba(255, 255, 255, 0.95);" onmouseover="this.style.color='#F4C430'" onmouseout="this.style.color='rgba(255, 255, 255, 0.95)'">Visit Our Campus</a></li>
                </ul>
            </div>

            <!-- Office Timings -->
            <div class="mb-8 sm:mb-0">
                <h3 class="text-lg sm:text-xl font-bold mb-4 sm:mb-6" style="color: #F4C430;">Office Timings</h3>
                <div class="space-y-2 sm:space-y-3 text-sm sm:text-base" style="color: rgba(255, 255, 255, 0.95);">
                    @php
                        $businessHours = \App\Helpers\SiteSettingsHelper::businessHours();
                    @endphp
                    @if($businessHours)
                        {!! nl2br(e($businessHours)) !!}
                    @else
                        <p>Sun-Thu: 9AM - 5PM</p>
                        <p>Fri & Sat: Closed</p>
                    @endif
                </div>
            </div>

        </div>

        <!-- Bottom Bar with Copyright and Social Media -->
        <div class="mt-8 sm:mt-12 pt-6 sm:pt-8" style="border-top: 1px solid rgba(255, 255, 255, 0.15);">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-0">
                <p class="text-xs sm:text-sm text-center sm:text-left mb-4 sm:mb-0" style="color: rgba(255, 255, 255, 0.85);">
                    @php
                        $siteName = \App\Helpers\SiteSettingsHelper::websiteName();
                        $copyright = \App\Helpers\SiteSettingsHelper::copyrightNotice();
                    @endphp
                    @if($copyright)
                        {{ str_replace('{year}', date('Y'), $copyright) }}
                    @else
                        © {{ date('Y') }} {{ $siteName }}. All rights reserved.
                    @endif
                </p>
                <div class="flex flex-wrap justify-center sm:justify-end gap-3 sm:gap-4">
                    @php
                        $socialLinks = \App\Helpers\SiteSettingsHelper::socialLinks();
                    @endphp
                    @if(!empty($socialLinks['facebook']))
                    <a href="{{ $socialLinks['facebook'] }}" target="_blank" rel="noopener noreferrer" class="transition-colors duration-300 min-w-[44px] min-h-[44px] flex items-center justify-center rounded-lg hover:bg-white/10" style="color: rgba(255, 255, 255, 0.85);" onmouseover="this.style.color='#F4C430'" onmouseout="this.style.color='rgba(255, 255, 255, 0.85)'" aria-label="Facebook">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    @endif
                    @if(!empty($socialLinks['twitter']))
                    <a href="{{ $socialLinks['twitter'] }}" target="_blank" rel="noopener noreferrer" class="transition-colors duration-300 min-w-[44px] min-h-[44px] flex items-center justify-center rounded-lg hover:bg-white/10" style="color: rgba(255, 255, 255, 0.85);" onmouseover="this.style.color='#F4C430'" onmouseout="this.style.color='rgba(255, 255, 255, 0.85)'" aria-label="Twitter">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    @endif
                    @if(!empty($socialLinks['youtube']))
                    <a href="{{ $socialLinks['youtube'] }}" target="_blank" rel="noopener noreferrer" class="transition-colors duration-300 min-w-[44px] min-h-[44px] flex items-center justify-center rounded-lg hover:bg-white/10" style="color: rgba(255, 255, 255, 0.85);" onmouseover="this.style.color='#F4C430'" onmouseout="this.style.color='rgba(255, 255, 255, 0.85)'" aria-label="YouTube">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    @endif
                    @if(!empty($socialLinks['instagram']))
                    <a href="{{ $socialLinks['instagram'] }}" target="_blank" rel="noopener noreferrer" class="transition-colors duration-300 min-w-[44px] min-h-[44px] flex items-center justify-center rounded-lg hover:bg-white/10" style="color: rgba(255, 255, 255, 0.85);" onmouseover="this.style.color='#F4C430'" onmouseout="this.style.color='rgba(255, 255, 255, 0.85)'" aria-label="Instagram">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.75.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.987C24.007 5.367 18.641.001.012.017z"/>
                        </svg>
                    </a>
                    @endif
                    @if(!empty($socialLinks['linkedin']))
                    <a href="{{ $socialLinks['linkedin'] }}" target="_blank" rel="noopener noreferrer" class="transition-colors duration-300 min-w-[44px] min-h-[44px] flex items-center justify-center rounded-lg hover:bg-white/10" style="color: rgba(255, 255, 255, 0.85);" onmouseover="this.style.color='#F4C430'" onmouseout="this.style.color='rgba(255, 255, 255, 0.85)'" aria-label="LinkedIn">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>
