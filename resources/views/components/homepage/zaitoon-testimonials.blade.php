{{-- Zaitoon Academy: Testimonials (FR-11) --}}
@php
    // Get testimonials from homepage sections (FR-11.4)
    $homePageSections = $homePageSections ?? collect([]);
    $testimonialSection = $homePageSections->get('testimonials') ?? $homePageSections->get('parent_testimonials');
    
    // Check if section is active
    if ($testimonialSection && !$testimonialSection->is_active) {
        return; // Don't render if section is inactive
    }
    
    $testimonials = [];
    if ($testimonialSection && isset($testimonialSection->data)) {
        $testimonials = $testimonialSection->data['testimonials'] ?? [];
    }
    
    // Get section title and description from database
    $sectionTitle = $testimonialSection?->title ?? 'What Parents Say About Duha International School';
    $sectionDescription = $testimonialSection?->description ?? null;
    
    // No default testimonials - only show if testimonials exist
    if (empty($testimonials)) {
        return; // Don't render section if no testimonials
    }
    
    $totalTestimonials = count($testimonials);
@endphp

<section class="py-16 lg:py-24 relative overflow-hidden"
         style="background: linear-gradient(to bottom, #e0f5f0 0%, #f0faf7 50%, #ffffff 100%);"
         x-data="{
             currentTestimonial: 0,
             totalTestimonials: {{ $totalTestimonials }},
             autoplayInterval: null,
             isPaused: false,
             init() {
                 if (this.totalTestimonials > 1) {
                     this.startAutoplay();
                 }
                 this.$el.addEventListener('mouseenter', () => { this.isPaused = true; });
                 this.$el.addEventListener('mouseleave', () => { this.isPaused = false; });
             },
             startAutoplay() {
                 this.autoplayInterval = setInterval(() => {
                     if (!this.isPaused) {
                         this.currentTestimonial = (this.currentTestimonial + 1) % this.totalTestimonials;
                     }
                 }, 5000);
             }
         }">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header (FR-11.1) --}}
        <div class="text-center mb-16 fade-in">
            <h2 class="text-2xl sm:text-3xl font-bold" style="color: #008236;">
                {{ $sectionTitle }}
            </h2>
            @if($sectionDescription)
            <p class="text-sm sm:text-base text-gray-600 max-w-3xl mx-auto mt-4">
                {{ $sectionDescription }}
            </p>
            @endif
        </div>
        
        {{-- Testimonial Carousel (FR-11.2, FR-11.3) --}}
        <div class="max-w-4xl mx-auto relative" style="min-height: 400px;">
            <template x-for="(testimonial, index) in {{ json_encode($testimonials) }}" :key="index">
                <div 
                    x-show="currentTestimonial === index"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-300 absolute inset-0"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="text-center px-8"
                >
                    {{-- Quote Icon (FR-11.2.2) --}}
                    <div class="flex justify-center mb-6">
                        <svg class="w-10 h-10" style="color: #7dd3c0;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.996 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.984zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.432.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>
                    </div>
                    
                    {{-- Author Avatar (FR-11.2.5) --}}
                    <div class="flex justify-center mb-6">
                        <div class="shrink-0 w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center" style="border: 4px solid #a8e6d8;">
                            <span class="text-gray-400 text-2xl font-bold" x-text="testimonial.author ? testimonial.author.charAt(0) : 'P'"></span>
                        </div>
                    </div>
                    
                    {{-- Testimonial Quote (FR-11.2.4) --}}
                    <p class="text-sm sm:text-base leading-relaxed mb-6 italic" style="color: #b0b0b0;">
                        <span x-text="testimonial.quote"></span>
                    </p>
                    
                    {{-- Author Name (FR-11.2.6) --}}
                    <p class="text-sm font-medium" style="color: #7dd3c0;">
                        <span x-text="'— ' + testimonial.author + ', Parent of ' + testimonial.student"></span>
                    </p>
                </div>
            </template>
            
            {{-- Navigation Arrows & Pagination (FR-11.3.3) --}}
            @if($totalTestimonials > 1)
            <div class="flex justify-center items-center gap-6 mt-12">
                {{-- Previous Button --}}
                <button 
                    @click="currentTestimonial = currentTestimonial === 0 ? totalTestimonials - 1 : currentTestimonial - 1"
                    class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2"
                    style="background-color: #008236;"
                    aria-label="Previous testimonial"
                >
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                
                {{-- Pagination Dots --}}
                <div class="flex gap-2" role="tablist" aria-label="Testimonial navigation">
                    @foreach($testimonials as $index => $test)
                    <button 
                        @click="currentTestimonial = {{ $index }}"
                        class="w-2.5 h-2.5 rounded-full transition-all duration-200 focus:outline-none"
                        :style="currentTestimonial === {{ $index }} ? 'background-color: #008236;' : 'background-color: #d1d5db;'"
                        :aria-selected="currentTestimonial === {{ $index }}"
                        aria-label="Go to testimonial {{ $index + 1 }}"
                        role="tab"
                    >
                    </button>
                    @endforeach
                </div>
                
                {{-- Next Button --}}
                <button 
                    @click="currentTestimonial = (currentTestimonial + 1) % totalTestimonials"
                    class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2"
                    style="background-color: #008236;"
                    aria-label="Next testimonial"
                >
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
            @endif
        </div>
    </div>
</section>

