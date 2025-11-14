<!-- Footer - AISD Style with Newsletter Signup -->
<footer class="bg-aisd-midnight text-white relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;80&quot; height=&quot;80&quot; viewBox=&quot;0 0 80 80&quot;><g fill-rule=&quot;evenodd&quot;><g fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.05&quot;><path d=&quot;M0 0h80v80H0V0zm20 20v40h40V20H20zm20 35a15 15 0 100-30 15 15 0 000 30z&quot;/></g></g></svg>'); background-size: 80px 80px;"></div>
    </div>
    
    <!-- Main Footer Content -->
    <div class="container mx-auto px-6 lg:px-12 py-16 relative z-10">
        <div class="grid lg:grid-cols-4 gap-8 mb-12">
            <!-- School Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Logo/Name -->
                <div>
                    @php
                        $siteName = \App\Helpers\SiteHelper::getSiteName();
                        $siteDescription = \App\Helpers\SiteHelper::getSiteDescription();
                    @endphp
                    <h3 class="text-2xl font-bold mb-3 text-white">{{ $siteName }}</h3>
                    <p class="text-white/80 text-lg leading-relaxed max-w-md">
                        {{ $siteDescription }}
                    </p>
                </div>
                
                <!-- Contact Info -->
                <div class="space-y-4">
                    @if($settings?->address)
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-aisd-gold/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1 border border-aisd-gold/30">
                            <svg class="w-4 h-4 text-aisd-gold" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-white">Address</div>
                            <div class="text-white/70">{{ $settings->address }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($settings?->contact_phone)
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-aisd-gold/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1 border border-aisd-gold/30">
                            <svg class="w-4 h-4 text-aisd-gold" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-white">Phone</div>
                            <div class="text-white/70">{{ $settings->contact_phone }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($settings?->contact_email)
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-aisd-gold/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1 border border-aisd-gold/30">
                            <svg class="w-4 h-4 text-aisd-gold" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-white">Email</div>
                            <div class="text-white/70">{{ $settings->contact_email }}</div>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Social Links -->
                <div>
                    <div class="font-semibold mb-3 text-white">Follow Us</div>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-white/10 border border-white/20 rounded-lg flex items-center justify-center hover:bg-aisd-gold/20 hover:border-aisd-gold/50 transition-all backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white hover:text-aisd-gold transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 border border-white/20 rounded-lg flex items-center justify-center hover:bg-aisd-gold/20 hover:border-aisd-gold/50 transition-all backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white hover:text-aisd-gold transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 border border-white/20 rounded-lg flex items-center justify-center hover:bg-aisd-gold/20 hover:border-aisd-gold/50 transition-all backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white hover:text-aisd-gold transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-bold mb-6 text-white">Quick Links</h4>
                <ul class="space-y-3">
                    <li><a href="#about" class="text-white/70 hover:text-aisd-gold transition-colors">About Us</a></li>
                    <li><a href="#programs" class="text-white/70 hover:text-aisd-gold transition-colors">Academic Programs</a></li>
                    <li><a href="#admissions" class="text-white/70 hover:text-aisd-gold transition-colors">Admissions</a></li>
                    <li><a href="#facilities" class="text-white/70 hover:text-aisd-gold transition-colors">Facilities</a></li>
                    <li><a href="#faculty" class="text-white/70 hover:text-aisd-gold transition-colors">Faculty</a></li>
                    <li><a href="#events" class="text-white/70 hover:text-aisd-gold transition-colors">Events</a></li>
                    <li><a href="#contact" class="text-white/70 hover:text-aisd-gold transition-colors">Contact</a></li>
                </ul>
            </div>
            
            <!-- Important Info -->
            <div>
                <h4 class="text-lg font-bold mb-6 text-white">Important</h4>
                <ul class="space-y-3">
                    <li><a href="#" class="text-white/70 hover:text-aisd-gold transition-colors">Student Portal</a></li>
                    <li><a href="#" class="text-white/70 hover:text-aisd-gold transition-colors">Parent Portal</a></li>
                    <li><a href="#" class="text-white/70 hover:text-aisd-gold transition-colors">Online Payments</a></li>
                    <li><a href="#" class="text-white/70 hover:text-aisd-gold transition-colors">Academic Calendar</a></li>
                    <li><a href="#" class="text-white/70 hover:text-aisd-gold transition-colors">Policies</a></li>
                    <li><a href="#" class="text-white/70 hover:text-aisd-gold transition-colors">Privacy Policy</a></li>
                    <li><a href="#" class="text-white/70 hover:text-aisd-gold transition-colors">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Newsletter Signup - AISD Style -->
        <div class="bg-gradient-to-r from-aisd-ocean/50 to-aisd-cobalt/50 rounded-2xl p-8 mb-12 border border-white/10 backdrop-blur-sm">
            <div class="grid md:grid-cols-2 gap-6 items-center">
                <div>
                    <h4 class="text-2xl font-bold mb-2 text-white">Stay Connected</h4>
                    <p class="text-white/80">Get the latest updates about school events, achievements, and important announcements. Join our Islamic schooling community newsletter.</p>
                </div>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input 
                        type="text" 
                        name="name" 
                        placeholder="Your name (optional)" 
                        class="flex-1 px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-aisd-gold focus:border-aisd-gold backdrop-blur-sm"
                    >
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="Enter your email" 
                        required
                        class="flex-1 px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-aisd-gold focus:border-aisd-gold backdrop-blur-sm"
                    >
                    <button 
                        type="submit"
                        class="bg-aisd-gold hover:bg-aisd-gold/90 text-aisd-midnight font-bold px-6 py-3 rounded-lg transition-all whitespace-nowrap shadow-lg hover:shadow-aisd-gold/50"
                    >
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Bottom Bar -->
    <div class="border-t border-white/10">
        <div class="container mx-auto px-6 lg:px-12 py-6 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-white/60 text-sm">
                    @php
                        $siteName = \App\Helpers\SiteHelper::getSiteName();
                    @endphp
                    © {{ date('Y') }} {{ $siteName }}. All rights reserved.
                </div>
                <div class="flex items-center space-x-6 text-sm">
                    <a href="#" class="text-white/60 hover:text-aisd-gold transition-colors">Privacy Policy</a>
                    <a href="#" class="text-white/60 hover:text-aisd-gold transition-colors">Terms of Service</a>
                    <a href="#" class="text-white/60 hover:text-aisd-gold transition-colors">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>
