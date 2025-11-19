<!-- Academic Programs Section - AISD Style -->
<section id="programs" class="py-20 relative overflow-hidden" style="background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 50%, #f8f9fa 100%);">
    <div class="container mx-auto px-6 lg:px-12 relative z-10">
        @php
            $section = $homePageSections['academic_programs'] ?? null;
            $sectionData = $section && $section->is_active ? $section->data : [];
            $subtitle = $sectionData['subtitle'] ?? 'Academic Excellence';
            $title = $sectionData['title'] ?? $section?->title ?? 'Our Academic Programs';
            $description = $sectionData['description'] ?? $section?->description ?? 'Comprehensive educational pathways designed to nurture intellectual growth, spiritual development, and global competency from early years through secondary education.';
            $programs = $sectionData['programs'] ?? [];
            $specialFeatures = $sectionData['special_features'] ?? [];
        @endphp

        @if($section && $section->is_active)
        <!-- Section Header -->
        <div class="text-center mb-10 sm:mb-16 px-4">
            <div class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 rounded-full text-xs sm:text-sm font-semibold mb-4 sm:mb-6" style="background-color: #FFF8E7; color: #173B7A; border: 1px solid #F4C430;">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" style="color: #F4C430;">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                </svg>
                {{ $subtitle }}
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-4 sm:mb-6" style="color: #0C1B3D;">
                {{ $title }}
            </h2>
            <p class="text-base sm:text-lg max-w-3xl mx-auto leading-relaxed px-4" style="color: #4a5568;">
                {{ $description }}
            </p>
        </div>
        
        @if(count($programs) > 0)
        <!-- Programs Grid - Single row on desktop -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:flex lg:flex-row gap-4 sm:gap-6 md:gap-8 mb-12 sm:mb-16">
            @foreach($programs as $program)
            <div class="group relative lg:flex-1 lg:min-w-0">
                <div class="rounded-2xl p-4 sm:p-6 md:p-8 h-full transition-all duration-500 border" style="background-color: #ffffff; border-color: #d1d5db; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';">
                    <!-- Icon -->
                    <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 rounded-2xl flex items-center justify-center mb-4 sm:mb-6 transition-transform duration-300" style="background-color: <?php echo $program['icon_bg_color'] ?? '#6EC1F5'; ?>;" onmouseover="this.style.transform='scale(1.1)';" onmouseout="this.style.transform='scale(1)';">
                        @if(isset($program['icon']) && $program['icon'])
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8" fill="currentColor" viewBox="0 0 24 24" style="color: #ffffff;">
                            <path d="{{ $program['icon'] }}" />
                        </svg>
                        @else
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8" fill="currentColor" viewBox="0 0 20 20" style="color: #ffffff;">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                        </svg>
                        @endif
                    </div>
                    
                    <!-- Content -->
                    <h3 class="text-xl sm:text-2xl font-bold mb-3 sm:mb-4" style="color: #0C1B3D;">{{ $program['title'] ?? '' }}</h3>
                    <div class="text-sm sm:text-base font-semibold mb-3 sm:mb-4" style="color: <?php echo $program['icon_bg_color'] ?? '#6EC1F5'; ?>;">{{ $program['grade_range'] ?? '' }}</div>
                    <p class="mb-4 sm:mb-6 text-sm sm:text-base leading-relaxed" style="color: #4a5568;">
                        {{ $program['description'] ?? '' }}
                    </p>
                    
                    <!-- Features -->
                    @if(isset($program['features']) && count($program['features']) > 0)
                    <ul class="space-y-3 text-sm">
                        @foreach($program['features'] as $feature)
                        <li class="flex items-center" style="color: #4a5568;">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" style="color: #F4C430;">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ $feature['text'] ?? '' }}
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        @endif

        @if(isset($specialFeatures['title']) && $specialFeatures['title'])
        <!-- Special Features Section -->
        <div class="rounded-2xl p-6 sm:p-8 md:p-12 relative overflow-hidden" style="background: linear-gradient(135deg, #4A90E2, #6EC1F5); color: #ffffff;">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot;><g fill-rule=&quot;evenodd&quot;><g fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.1&quot;><circle cx=&quot;30&quot; cy=&quot;30&quot; r=&quot;2&quot;/></g></g></svg>'); background-size: 60px 60px;"></div>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-6 sm:gap-8 md:gap-12 items-center relative z-10">
                <div>
                    <h3 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 sm:mb-6">
                        {{ $specialFeatures['title'] }}
                    </h3>
                    <p class="text-base sm:text-lg mb-6 sm:mb-8 leading-relaxed" style="color: rgba(255, 255, 255, 0.9);">
                        {{ $specialFeatures['description'] ?? '' }}
                    </p>
                    
                    @if(isset($specialFeatures['features']) && count($specialFeatures['features']) > 0)
                    <!-- Features Grid -->
                    <div class="grid grid-cols-2 gap-3 sm:gap-4 md:gap-6">
                        @foreach($specialFeatures['features'] as $feature)
                        <div class="text-center">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl mx-auto mb-2 sm:mb-3 flex items-center justify-center" style="background-color: #F4C430;">
                                @if(isset($feature['icon']) && $feature['icon'])
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24" style="color: #0C1B3D;">
                                    <path d="{{ $feature['icon'] }}" />
                                </svg>
                                @else
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20" style="color: #0C1B3D;">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/>
                                </svg>
                                @endif
                            </div>
                            <div class="text-sm sm:text-base font-bold">{{ $feature['title'] ?? '' }}</div>
                            <div class="text-xs sm:text-sm" style="color: rgba(255, 255, 255, 0.8);">{{ $feature['subtitle'] ?? '' }}</div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                
                <div class="text-center">
                    <div class="rounded-2xl p-4 sm:p-6 md:p-8" style="background-color: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                        <h4 class="text-xl sm:text-2xl font-bold mb-3 sm:mb-4">Ready to Join Us?</h4>
                        <p class="mb-4 sm:mb-6 text-sm sm:text-base" style="color: rgba(255, 255, 255, 0.9);">
                            Discover how our programs can nurture your child's potential
                        </p>
                        @if(isset($specialFeatures['cta']['text']) && isset($specialFeatures['cta']['link']))
                        <a href="{{ $specialFeatures['cta']['link'] }}" class="inline-flex items-center justify-center font-bold py-3 px-6 sm:px-8 rounded-lg transition-all duration-300 min-h-[44px] w-full sm:w-auto" style="background-color: #F4C430; color: #0C1B3D;" onmouseover="this.style.backgroundColor='#ffdc5c'; this.style.transform='scale(1.05)'" onmouseout="this.style.backgroundColor='#F4C430'; this.style.transform='scale(1)'">
                            {{ $specialFeatures['cta']['text'] }}
                            <svg class="ml-2 w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endif
    </div>
    
    <!-- Curved Wave at Bottom -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden pointer-events-none" style="line-height: 0; z-index: 0;">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" style="position: relative; display: block; width: 100%; height: 100px;">
            <path d="M0,0 C480,120 960,120 1440,0 L1440,120 L0,120 Z" style="fill: #1e3a5f;"></path>
        </svg>
    </div>
</section>