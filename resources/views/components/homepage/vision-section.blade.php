<!-- Vision & Mission Section - AISD Style with Decorative Star Motif -->
@php
    $section = $homePageSections['vision'] ?? null;
    $sectionData = $section && $section->is_active ? $section->data : [];
    
    // Badge and Heading
    $badgeText = $sectionData['badge_text'] ?? 'Our Charter';
    $headingLine1 = $sectionData['heading_line1'] ?? 'Empowering Minds,';
    $headingLine2 = $sectionData['heading_line2'] ?? 'Enriching Hearts';
    $description = $section?->description ?? $sectionData['description'] ?? 'We follow the footsteps of Duha with a distinctly Islamic ethos—uniting rigorous academics and tarbiyah to nurture resilient, compassionate leaders.';
    
    // Vision & Mission
    $visionTitle = $sectionData['vision_title'] ?? 'Vision';
    $visionText = $sectionData['vision_text'] ?? 'To cultivate God-conscious learners who lead with integrity and scholarship across the globe.';
    $missionTitle = $sectionData['mission_title'] ?? 'Mission';
    $missionText = $sectionData['mission_text'] ?? 'Deliver Cambridge excellence infused with Qur\'anic sciences, Arabic, and service learning pathways.';
    
    // Features
    $defaultFeatures = [
        ['text' => 'Cambridge Primary to A-Level'],
        ['text' => 'Hifz & Nazira Tracks'],
        ['text' => 'Leadership & Service Labs'],
    ];
    $features = $sectionData['features'] ?? $defaultFeatures;
    
    // Campus Image
    $imageTitle = $sectionData['image_title'] ?? 'Our Campus';
    $imageSubtitle = $sectionData['image_subtitle'] ?? 'Where tradition meets innovation';
    $campusImageUrl = $section && $section->hasMedia('images') 
        ? $section->getMediaUrlRelative('images') 
        : asset('images/vision-campus.svg');
    
    // Core Values
    $valuesTitle = $sectionData['values_title'] ?? 'Core Values';
    $defaultValues = [
        ['value' => 'Ihsan in every lesson'],
        ['value' => 'Amanah & compassion'],
        ['value' => 'Lifelong inquiry'],
    ];
    $coreValues = $sectionData['core_values'] ?? $defaultValues;
@endphp

@if($section && $section->is_active)
<section id="vision" class="relative py-12 sm:py-16 md:py-24 overflow-hidden" style="background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 50%, #f8f9fa 100%);">
    <!-- Decorative star pattern background -->
    <div class="absolute inset-0 opacity-5" style="background-image:url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;200&quot; height=&quot;200&quot; viewBox=&quot;0 0 200 200&quot;><g fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;><path d=&quot;M100 0l20 60-60 20 60 20-20 60-20-60-60-20 60-20z&quot; stroke=&quot;%23F4C430&quot; stroke-width=&quot;1&quot; opacity=&quot;.4&quot;/></g></svg>');">></div>

    <div class="container relative z-10 mx-auto px-4 sm:px-6 lg:px-12">
        <div class="grid items-center gap-8 sm:gap-10 md:gap-12 lg:grid-cols-2">
            <!-- Left Content -->
            <div class="space-y-4 sm:space-y-6 order-2 lg:order-1">
                <!-- Section Badge -->
                <div class="inline-flex items-center gap-2 sm:gap-3 rounded-full px-3 sm:px-4 py-1.5 sm:py-2 text-xs font-semibold uppercase tracking-[0.5em]" style="background-color: #ffffff; color: #173B7A; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <span class="h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full" style="background-color: #F4C430;"></span>
                    {{ $badgeText }}
                </div>

                <!-- Main Heading -->
                <h2 class="text-2xl sm:text-3xl font-bold md:text-4xl lg:text-5xl leading-tight" style="color: #0C1B3D;">
                    {{ $headingLine1 }}<br>
                    <span style="color: #173B7A;">{{ $headingLine2 }}</span>
                </h2>

                <!-- Description -->
                <p class="text-base sm:text-lg leading-relaxed" style="color: #4a5568;">
                    {{ $description }}
                </p>

                <!-- Vision & Mission Cards -->
                <div class="grid gap-4 sm:gap-6 lg:grid-cols-2">
                    <!-- Vision Card -->
                    <div class="rounded-2xl border p-4 sm:p-6 transition-all" style="border-color: #d1d5db; background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'">
                        <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4" style="color: #F4C430;">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <p class="text-xs font-semibold uppercase tracking-[0.4em]" style="color: #0C1B3D;">{{ $visionTitle }}</p>
                        </div>
                        <p class="text-sm sm:text-base leading-relaxed" style="color: #0C1B3D;">{{ $visionText }}</p>
                    </div>

                    <!-- Mission Card -->
                    <div class="rounded-2xl border p-4 sm:p-6 transition-all" style="border-color: #d1d5db; background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'">
                        <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4" style="color: #F4C430;">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <p class="text-xs font-semibold uppercase tracking-[0.4em]" style="color: #0C1B3D;">{{ $missionTitle }}</p>
                        </div>
                        <p class="text-sm sm:text-base leading-relaxed" style="color: #0C1B3D;">{{ $missionText }}</p>
                    </div>
                </div>

                <!-- Feature Pills -->
                @if(count($features) > 0)
                <div class="flex flex-wrap gap-2 sm:gap-4 text-xs sm:text-sm">
                    @foreach($features as $feature)
                    <div class="flex items-center gap-2 rounded-full px-3 sm:px-4 py-1.5 sm:py-2" style="background-color: #ffffff; color: #4a5568; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                        <span class="h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full" style="background-color: #F4C430;"></span>
                        {{ $feature['text'] }}
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Right Content - Image with decorative elements -->
            <div class="relative order-1 lg:order-2">
                <!-- Main Image Container -->
                <div class="aspect-[4/5] rounded-2xl sm:rounded-[24px] md:rounded-[32px] p-3 sm:p-4 md:p-6 overflow-hidden" style="background-color: #0C1B3D; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
                    <div class="h-full w-full rounded-[24px] bg-cover bg-center relative" style="background-image:url('{{ $campusImageUrl }}');">
                        <div class="absolute inset-0 rounded-[24px]" style="background: linear-gradient(180deg, transparent 0%, rgba(12, 27, 61, 0.6) 60%, rgba(12, 27, 61, 0.9) 100%);"></div>

                        <!-- Overlay Content -->
                        <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 md:p-8">
                            <h3 class="text-lg sm:text-xl md:text-2xl font-bold mb-1 sm:mb-2" style="color: #ffffff;">{{ $imageTitle }}</h3>
                            <p class="text-xs sm:text-sm" style="color: rgba(255, 255, 255, 0.9);">{{ $imageSubtitle }}</p>
                        </div>
                    </div>
                </div>

                <!-- Floating Core Values Card -->
                @if(count($coreValues) > 0)
                <div class="absolute -bottom-4 sm:-bottom-6 -right-4 sm:-right-6 rounded-xl sm:rounded-2xl p-3 sm:p-4 md:p-5" style="background-color: #ffffff; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 10px 10px -5px rgba(0, 0, 0, 0.1);">
                    <p class="text-[10px] sm:text-xs uppercase tracking-[0.4em] mb-2 sm:mb-3" style="color: #173B7A;">{{ $valuesTitle }}</p>
                    <ul class="space-y-1 sm:space-y-2 text-xs sm:text-sm" style="color: #0C1B3D;">
                        @foreach($coreValues as $value)
                        <li class="flex items-center gap-1.5 sm:gap-2">
                            <span class="h-1 sm:h-1.5 w-1 sm:w-1.5 rounded-full" style="background-color: #F4C430;"></span>
                            {{ $value['value'] }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Decorative Star Element -->
                <div class="absolute -top-4 sm:-top-6 -left-4 sm:-left-6 w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 opacity-20 hidden sm:block">
                    <svg class="w-full h-full text-aisd-gold" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>
@endif


