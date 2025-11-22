@props(['slides' => []])

<div 
    x-data="{ 
        activeSlide: 0,
        slides: {{ json_encode($slides) }},
        autoplayInterval: null,
        next() {
            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
        },
        prev() {
            this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
        },
        startAutoplay() {
            this.autoplayInterval = setInterval(() => {
                this.next();
            }, 5000);
        },
        stopAutoplay() {
            clearInterval(this.autoplayInterval);
        }
    }"
    x-init="startAutoplay()"
    @mouseenter="stopAutoplay()"
    @mouseleave="startAutoplay()"
    class="relative w-full h-[500px] lg:h-[700px] overflow-hidden bg-gray-900 group"
>
    <!-- Slides -->
    <template x-for="(slide, index) in slides" :key="index">
        <div 
            x-show="activeSlide === index"
            x-transition:enter="transition transform duration-1000 ease-out"
            x-transition:enter-start="opacity-0 scale-105"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition transform duration-1000 ease-in"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute inset-0 w-full h-full"
        >
            <!-- Image -->
            <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover opacity-60">
            
            <!-- Overlay Gradient -->
            <div class="absolute inset-0 bg-gradient-to-t from-zaitoon-primary/90 via-zaitoon-primary/40 to-transparent"></div>

            <!-- Content -->
            <div class="absolute inset-0 flex items-center justify-center text-center px-4">
                <div class="max-w-4xl space-y-6" 
                     x-show="activeSlide === index"
                     x-transition:enter="transition ease-out duration-1000 delay-300"
                     x-transition:enter-start="opacity-0 translate-y-10"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    
                    <h2 x-text="slide.subtitle" class="text-zaitoon-secondary text-lg md:text-xl font-bold tracking-widest uppercase mb-2"></h2>
                    <h1 x-text="slide.title" class="text-4xl md:text-6xl lg:text-7xl font-serif font-bold text-white leading-tight drop-shadow-lg"></h1>
                    <p x-text="slide.description" class="text-gray-200 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed hidden md:block"></p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                        <template x-if="slide.cta_primary">
                            <a :href="slide.cta_primary.url" class="px-8 py-4 bg-zaitoon-secondary text-zaitoon-primary font-bold rounded-full hover:bg-white transition-all shadow-lg transform hover:-translate-y-1" x-text="slide.cta_primary.text"></a>
                        </template>
                        <template x-if="slide.cta_secondary">
                            <a :href="slide.cta_secondary.url" class="px-8 py-4 border-2 border-white text-white font-bold rounded-full hover:bg-white hover:text-zaitoon-primary transition-all shadow-lg transform hover:-translate-y-1" x-text="slide.cta_secondary.text"></a>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Navigation Arrows -->
    <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 p-3 rounded-full bg-white/10 text-white hover:bg-zaitoon-secondary hover:text-zaitoon-primary transition-all backdrop-blur-sm opacity-0 group-hover:opacity-100 focus:opacity-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
    </button>
    <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 p-3 rounded-full bg-white/10 text-white hover:bg-zaitoon-secondary hover:text-zaitoon-primary transition-all backdrop-blur-sm opacity-0 group-hover:opacity-100 focus:opacity-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </button>

    <!-- Dots -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-3">
        <template x-for="(slide, index) in slides" :key="index">
            <button 
                @click="activeSlide = index" 
                class="w-3 h-3 rounded-full transition-all duration-300"
                :class="activeSlide === index ? 'bg-zaitoon-secondary w-8' : 'bg-white/50 hover:bg-white'"
            ></button>
        </template>
    </div>
</div>
