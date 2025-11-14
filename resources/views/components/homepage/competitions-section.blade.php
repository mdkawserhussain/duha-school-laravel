<!-- Competitions Section - AISD Style with Skewed Cards -->
<section class="py-24" id="competitions" style="background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);">
    <div class="container mx-auto px-6 lg:px-12">
        <!-- Section Header -->
        <div class="flex flex-col gap-6 text-center mb-16">
            <div class="inline-flex items-center justify-center gap-2 mx-auto rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.5em]" style="background-color: #FFF8E7; color: #173B7A; border: 1px solid #F4C430;">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" style="color: #F4C430;">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                Competitions
            </div>
            <h2 class="text-3xl font-bold md:text-4xl lg:text-5xl" style="color: #0C1B3D;">Excellence in Academic & Islamic Pursuits</h2>
            <p class="mx-auto max-w-3xl leading-relaxed" style="color: #4a5568;">Celebrating our students' achievements in tournaments, Olympiads, and Qur'anic competitions that showcase both knowledge and character.</p>
        </div>

        @php
            $competitions = [
                [
                    'title' => 'Arabic Oratory League',
                    'copy' => 'Students deliver khutbah-style speeches judged by scholars, developing eloquence and understanding of Islamic principles.',
                    'gradient' => 'linear-gradient(135deg, #173B7A, #0F224C)',
                    'iconBg' => '#173B7A',
                    'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'
                ],
                [
                    'title' => 'Mathematics Olympiad',
                    'copy' => 'Regional gold in junior category with perfect logic scores, demonstrating analytical excellence and problem-solving prowess.',
                    'gradient' => 'linear-gradient(135deg, #0C1B3D, #173B7A)',
                    'iconBg' => '#0C1B3D',
                    'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z'
                ],
                [
                    'title' => 'Qira\'ah Championship',
                    'copy' => 'National runner-up with flawless maqamat transitions, honoring the beauty and precision of Qur\'anic recitation.',
                    'gradient' => 'linear-gradient(135deg, #0F224C, #0C1B3D)',
                    'iconBg' => '#0F224C',
                    'icon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3'
                ],
            ];
        @endphp

        <!-- Competitions Grid with Skew -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($competitions as $index => $competition)
                <article class="group rounded-2xl border transition-all overflow-hidden" style="border-color: #e5e7eb; background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'">
                    <!-- Colored Top Bar -->
                    <div class="h-2" style="background: {{ $competition['gradient'] }};"></div>
                    
                    <!-- Card Content -->
                    <div class="p-6">
                        <!-- Icon -->
                        <div class="inline-flex items-center justify-center rounded-xl p-3 mb-4" style="background-color: {{ $competition['iconBg'] }};">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24" style="color: #ffffff;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $competition['icon'] }}" />
                            </svg>
                        </div>
                        
                        <!-- Competition Number -->
                        <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider mb-3" style="background-color: #FFF8E7; color: #173B7A; border: 1px solid #F4C430;">
                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20" style="color: #F4C430;">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Achievement {{ $index + 1 }}
                        </div>
                        
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-3" style="color: #0C1B3D;">{{ $competition['title'] }}</h3>
                        
                        <!-- Description -->
                        <p class="text-sm leading-relaxed mb-6" style="color: #4a5568;">{{ $competition['copy'] }}</p>
                        
                        <!-- View Button -->
                        <button class="inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-semibold transition-all" style="background-color: #F4C430; color: #0C1B3D;" onmouseover="this.style.backgroundColor='#ffdc5c'; this.style.transform='scale(1.05)'" onmouseout="this.style.backgroundColor='#F4C430'; this.style.transform='scale(1)'">
                            View Details
                            <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </button>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
