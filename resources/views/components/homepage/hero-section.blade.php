<!-- Hero Section - AISD Style with Background Video -->
<section class="relative min-h-screen flex items-center overflow-hidden bg-aisd-midnight">
    <!-- Background Video Container - Using HTML5 Video -->
    <div class="absolute inset-0 w-full h-full overflow-hidden">
        <video 
            id="hero-bg-video"
            class="absolute top-1/2 left-1/2 min-w-full min-h-full w-auto h-auto -translate-x-1/2 -translate-y-1/2 object-cover"
            autoplay 
            muted 
            loop 
            playsinline
            poster="{{ asset('images/hero-poster.jpg') }}">
            <!-- Fallback to gradient if video not available -->
            <source src="https://storage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    
    <!-- Dark overlay for text readability -->
    <div class="absolute inset-0 bg-gradient-to-br from-aisd-midnight/85 via-aisd-ocean/80 to-aisd-cobalt/85"></div>
    
    <!-- Decorative pattern overlay -->
    <div class="absolute inset-0 opacity-15" style="background-image:url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;120&quot; height=&quot;120&quot; viewBox=&quot;0 0 120 120&quot;><g fill=&quot;none&quot; fill-rule=&quot;evenodd&quot; opacity=&quot;.25&quot;><path d=&quot;M60 0l60 60-60 60L0 60z&quot; stroke=&quot;%23F4C430&quot; stroke-width=&quot;0.5&quot; opacity=&quot;.3&quot;/></g></svg>');"></div>

    <div class="container relative z-10 mx-auto px-6 lg:px-12 py-20 lg:py-28">
        <div class="grid lg:grid-cols-[1.1fr_0.9fr] gap-16 items-center">
            <!-- Text content - Left side -->
            <div class="text-white space-y-8">
                <!-- School crest badge -->
                <div class="inline-flex items-center gap-3 rounded-full border border-white/20 bg-white/5 px-5 py-2 text-[0.65rem] uppercase tracking-[0.3em] backdrop-blur-sm">
                    <svg class="h-4 w-4 text-aisd-gold" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span>Since 2010 • Chattogram</span>
                </div>

                <!-- Main headline -->
                <h1 class="text-4xl font-bold leading-tight md:text-5xl xl:text-6xl tracking-tight">
                    Nurturing Excellence in Islamic Education
                </h1>

                <!-- Subtext -->
                <p class="text-lg text-white/90 max-w-2xl leading-relaxed">
                    A Cambridge and Islamic integrated curriculum inspiring young minds to lead with knowledge, character, and compassion.
                </p>

                <!-- Dual CTAs -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#admissions" class="inline-flex items-center justify-center rounded-xl bg-aisd-gold px-8 py-4 text-base font-semibold text-aisd-midnight transition-all hover:bg-aisd-gold/90 hover:shadow-lg hover:shadow-aisd-gold/50">
                        Apply Now
                        <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                    <a href="#virtual-tour" class="inline-flex items-center justify-center rounded-xl border-2 border-white/30 bg-white/10 px-8 py-4 text-base font-semibold text-white backdrop-blur-sm transition-all hover:bg-white/20 hover:border-white/50">
                        Virtual Tour
                        <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </a>
                </div>

                <!-- Feature highlights -->
                <div class="grid gap-6 text-sm sm:grid-cols-2">
                    <div class="flex items-start gap-3">
                        <div class="rounded-2xl bg-white/15 p-2 backdrop-blur-sm">
                            <svg class="h-5 w-5 text-aisd-gold sm:h-6 sm:w-6" fill="currentColor" viewBox="0 0 20 20" width="20" height="20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-base font-semibold">Cambridge & Hifz Streams</h4>
                            <p class="text-white/80 text-sm">Balanced academics with authentic Islamic scholarship.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="rounded-2xl bg-white/15 p-2 backdrop-blur-sm">
                            <svg class="h-5 w-5 text-aisd-gold sm:h-6 sm:w-6" fill="currentColor" viewBox="0 0 20 20" width="20" height="20">
                                <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                                <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-base font-semibold">Modern Islamic Campus</h4>
                            <p class="text-white/80 text-sm">Secure, tech-enabled classrooms and labs.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Highlight stats cards - Right side (desktop) -->
            <div class="grid gap-6">
                <div class="rounded-3xl border border-white/30 p-6 backdrop-blur-xl shadow-2xl" style="background: linear-gradient(135deg, rgba(15, 34, 76, 0.85), rgba(12, 27, 61, 0.9)); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);">
                    <div class="flex items-center justify-between text-sm text-white">
                        <span>Lower Campus</span>
                        <span>Morning Shift</span>
                    </div>
                    <h3 class="mt-4 text-3xl font-bold text-white">Early Years • Primary</h3>
                    <p class="mt-3 text-white">Cambridge Primary with Qur'an & Arabic immersion.</p>
                </div>
                <div class="rounded-3xl border border-white/30 p-6 backdrop-blur-xl shadow-2xl" style="background: linear-gradient(135deg, rgba(15, 34, 76, 0.85), rgba(12, 27, 61, 0.9)); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);">
                    <div class="flex items-center justify-between text-sm text-white">
                        <span>Upper Campus</span>
                        <span>Day Shift</span>
                    </div>
                    <h3 class="mt-4 text-3xl font-bold text-white">IGCSE & A-Level</h3>
                    <p class="mt-3 text-white">STEM, Business & Islamic leadership enrichment.</p>
                </div>
                <!-- Stats pills -->
                <div class="grid grid-cols-3 gap-4 text-center text-white">
                    <div class="rounded-2xl p-4 backdrop-blur-sm border border-white/30" style="background: linear-gradient(135deg, rgba(15, 34, 76, 0.8), rgba(12, 27, 61, 0.85)); box-shadow: 0 4px 16px 0 rgba(0, 0, 0, 0.3);">
                        <div class="text-3xl font-bold text-white">1200+</div>
                        <div class="text-xs uppercase tracking-wide text-white mt-1">Students</div>
                    </div>
                    <div class="rounded-2xl p-4 backdrop-blur-sm border border-white/30" style="background: linear-gradient(135deg, rgba(15, 34, 76, 0.8), rgba(12, 27, 61, 0.85)); box-shadow: 0 4px 16px 0 rgba(0, 0, 0, 0.3);">
                        <div class="text-3xl font-bold text-white">85</div>
                        <div class="text-xs uppercase tracking-wide text-white mt-1">Educators</div>
                    </div>
                    <div class="rounded-2xl p-4 backdrop-blur-sm border border-white/30" style="background: linear-gradient(135deg, rgba(15, 34, 76, 0.8), rgba(12, 27, 61, 0.85)); box-shadow: 0 4px 16px 0 rgba(0, 0, 0, 0.3);">
                        <div class="text-3xl font-bold text-white">15+</div>
                        <div class="text-xs uppercase tracking-wide text-white mt-1">Years</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll cue -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white z-10">
        <div class="flex flex-col items-center gap-2 text-xs tracking-[0.4em] uppercase">
            <span class="opacity-70">Scroll</span>
            <div class="h-12 w-8 rounded-full border border-white/40 flex items-start justify-center p-1">
                <span class="h-3 w-1 rounded-full bg-white animate-bounce"></span>
            </div>
        </div>
    </div>
</section>

<!-- Ensure video plays on load -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var video = document.getElementById('hero-bg-video');
        if (video) {
            video.muted = true;
            video.play().catch(function(error) {
                console.log('Video autoplay prevented:', error);
            });
        }
    });
</script>
