{{-- Zaitoon Academy: Testimonials (FR-11) --}}
@php
    // Get testimonials from homepage sections (FR-11.4)
    $homePageSections = $homePageSections ?? collect([]);
    $testimonialSection = $homePageSections->get('testimonials') ?? $homePageSections->get('parent_testimonials');
    $testimonials = [];
    if ($testimonialSection && isset($testimonialSection->data)) {
        $testimonials = $testimonialSection->data['testimonials'] ?? [];
    }
    
    // Default testimonial if none provided (FR-11.4.4)
    if (empty($testimonials)) {
        $testimonials = [
            [
                'quote' => 'Zaitoon Academy has provided excellent education for my child. The combination of Islamic and modern curriculum is outstanding.',
                'author' => 'Md. Shamimul Islam',
                'role' => 'Parent',
                'avatar' => null,
            ],
        ];
    }
    $totalTestimonials = count($testimonials);
@endphp

<section class="py-16 lg:py-24 bg-white relative overflow-hidden"
         x-data="{
             currentTestimonial: 0,
             totalTestimonials: {{ $totalTestimonials }},
             autoplayInterval: null,
             isPaused: false
         }"
         x-init="
             // Auto-play (FR-11.3.5)
             if (totalTestimonials > 1) {
                 autoplayInterval = setInterval(function() {
                     if (!isPaused) {
                         currentTestimonial = (currentTestimonial + 1) % totalTestimonials;
                     }
                 }, 5000);
             }
             
             $el.addEventListener('mouseenter', function() {
                 isPaused = true;
             });
             $el.addEventListener('mouseleave', function() {
                 isPaused = false;
             });
             
             $watch('currentTestimonial', function() {
                 if (totalTestimonials > 1 && !isPaused) {
                     clearInterval(autoplayInterval);
                     autoplayInterval = setInterval(function() {
                         if (!isPaused) {
                             currentTestimonial = (currentTestimonial + 1) % totalTestimonials;
                         }
                     }, 5000);
                 }
             });
         ">
    {{-- Light Green Gradient at Bottom (FR-11.1.3) --}}
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-za-green-50 to-transparent"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Section Header (FR-11.1) --}}
        <div class="text-center mb-12">
            <div class="inline-block mb-4">
                <svg class="w-16 h-16 text-za-green-primary opacity-20" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.996 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.984zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.432.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                </svg>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-za-green-primary mb-4">
                What Parents Say About Zaitoon Academy
            </h2>
        </div>
        
        {{-- Testimonial Carousel (FR-11.2, FR-11.3) --}}
        <div class="max-w-4xl mx-auto">
            <template x-for="(testimonial, index) in {{ json_encode($testimonials) }}" :key="index">
                <div 
                    x-show="currentTestimonial === index"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="bg-gray-50 rounded-2xl p-8 lg:p-12 shadow-lg relative"
                    style="display: {{ $totalTestimonials > 0 ? 'block' : 'none' }};"
                >
                    {{-- Quote Icon (FR-11.2.2) --}}
                    <div class="absolute top-6 left-6 opacity-10">
                        <svg class="w-20 h-20 text-za-green-primary" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.996 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.984zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.432.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>
                    </div>
                    
                    <div class="relative z-10">
                        {{-- Testimonial Quote (FR-11.2.4) --}}
                        <p class="text-lg sm:text-xl text-gray-700 leading-relaxed mb-6 italic" x-text="'\"' + (testimonial.quote || '') + '\"'"></p>
                        
                        {{-- Author Info (FR-11.2.5, FR-11.2.6) --}}
                        <div class="flex items-center gap-4">
                            <template x-if="testimonial.avatar">
                                <div class="flex-shrink-0">
                                    <img 
                                        :src="testimonial.avatar" 
                                        :alt="testimonial.author || 'Parent'"
                                        class="w-20 h-20 rounded-full object-cover border-4 border-za-green-light"
                                        loading="lazy"
                                    >
                                </div>
                            </template>
                            <template x-if="!testimonial.avatar">
                                <div class="flex-shrink-0 w-20 h-20 rounded-full bg-za-green-light border-4 border-za-green-light flex items-center justify-center">
                                    <span class="text-za-green-primary text-xl font-bold" x-text="(testimonial.author || 'P').charAt(0)"></span>
                                </div>
                            </template>
                            <div>
                                <p class="text-xl font-bold text-za-green-primary" x-text="testimonial.author || 'Parent'"></p>
                                <p class="text-sm text-gray-500" x-text="testimonial.role || ''"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            
            {{-- Pagination Dots (FR-11.3.3) --}}
            @if($totalTestimonials > 1)
            <div class="flex justify-center gap-2 mt-6" role="tablist" aria-label="Testimonial navigation">
                @foreach($testimonials as $index => $test)
                <button 
                    @click="currentTestimonial = {{ $index }}"
                    class="w-3 h-3 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-za-green-500"
                    :class="currentTestimonial === {{ $index }} ? 'bg-za-green-primary' : 'bg-gray-300'"
                    :aria-selected="currentTestimonial === {{ $index }}"
                    aria-label="Go to testimonial {{ $index + 1 }}"
                    role="tab"
                >
                </button>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>

