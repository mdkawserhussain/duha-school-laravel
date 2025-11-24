@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta-description', $page->meta_description)

@section('content')

    @php
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home')],
        ];
        
        if ($page->parent) {
            if ($page->parent->parent) {
                $breadcrumbs[] = ['title' => $page->parent->parent->title, 'url' => $page->parent->parent->url];
            }
            $breadcrumbs[] = ['title' => $page->parent->title, 'url' => $page->parent->url];
        } elseif ($page->page_category) {
            $categoryTitle = ucfirst(str_replace('-', ' ', $page->page_category));
            $categoryRoute = \App\Helpers\PageHelper::getCategoryIndexRoute($page->page_category);
            try {
                $categoryUrl = $categoryRoute ? route($categoryRoute) : $page->url;
            } catch (\Exception $e) {
                $categoryUrl = $page->url;
            }
            $breadcrumbs[] = ['title' => $categoryTitle, 'url' => $categoryUrl];
        }
        
        $breadcrumbs[] = ['title' => $page->title, 'url' => $page->url];
        
        // Extract profile data from page metadata or use defaults
        $profileData = $page->metadata ?? [];
        $leaderName = $profileData['leader_name'] ?? 'Dr. Ahmed Hassan';
        $leaderTitle = $profileData['leader_title'] ?? 'Founder & Director';
        $leaderImage = $page->hasMedia('profile_image') 
            ? $page->getMediaUrlRelative('profile_image', 'large') 
            : ($profileData['leader_image'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($leaderName) . '&size=400&background=0C1B3D&color=fff&bold=true');
        $leaderBio = $profileData['leader_bio'] ?? 'Dedicated to providing excellence in Islamic education with over 20 years of experience.';
        $leaderEmail = $profileData['leader_email'] ?? null;
        $leaderPhone = $profileData['leader_phone'] ?? null;
        $leaderLinkedin = $profileData['leader_linkedin'] ?? null;
    @endphp

    <!-- Breadcrumbs -->
    @if(count($breadcrumbs) > 1)
        <x-breadcrumbs :items="$breadcrumbs" />
    @endif

    {{-- Enhanced Hero Section with Gradient Background and Animations --}}
    @php
        $heroImage = $page->hasMedia('hero_image') 
            ? $page->getMediaUrlRelative('hero_image', 'large') 
            : null;
    @endphp

    <section class="relative bg-gradient-to-br from-[#E8F5E9] via-white to-[#E8F5E9] py-20 lg:py-28 overflow-hidden">
        {{-- Decorative Background Elements --}}
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-[#7AB91E]/10 to-transparent skew-x-12 transform origin-top-right"></div>
        <div class="absolute bottom-0 left-0 w-1/4 h-1/2 bg-gradient-to-t from-[#008236]/5 to-transparent rounded-tr-full"></div>
        <div class="absolute top-10 right-10 w-32 h-32 bg-[#008236]/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 left-10 w-40 h-40 bg-[#7AB91E]/10 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-4xl mx-auto text-center space-y-6">
                @if($page->hero_badge)
                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)" 
                     class="inline-flex items-center gap-2 rounded-full px-4 py-2 mb-6 text-xs font-semibold uppercase tracking-wider bg-white/80 border border-[#008236]/20 text-[#008236] backdrop-blur-sm opacity-0 transform translate-y-8 transition-all duration-1000 ease-out"
                     :class="{ 'opacity-100 translate-y-0': show }">
                    <span class="w-2 h-2 rounded-full bg-[#008236]"></span>
                    {{ $page->hero_badge }}
                </div>
                @endif

                <h1 x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" 
                    class="text-4xl lg:text-6xl font-bold text-[#008236] mb-6 leading-tight opacity-0 transform translate-y-8 transition-all duration-1000 ease-out"
                    :class="{ 'opacity-100 translate-y-0': show }">
                    {{ $page->title }}
                </h1>

                @if($page->hero_subtitle)
                <p x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)" 
                   class="text-gray-600 text-lg leading-relaxed max-w-2xl mx-auto opacity-0 transform translate-y-8 transition-all duration-1000 delay-300 ease-out"
                   :class="{ 'opacity-100 translate-y-0': show }">
                    {{ $page->hero_subtitle }}
                </p>
                @endif
            </div>
        </div>
    </section>

    <!-- Profile Card Section -->
    @if($leaderName)
    <section class="py-8 md:py-12 bg-gradient-to-b from-[#F9FAFB] to-white relative overflow-hidden">
        {{-- Decorative Background Elements --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-[#E8F5E9]/20 rounded-full opacity-20 -translate-x-32 -translate-y-32"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#008236]/5 rounded-full opacity-20 translate-x-48 translate-y-48"></div>
        
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" 
                 class="opacity-0 transform translate-y-8 transition-all duration-1000 ease-out"
                 :class="{ 'opacity-100 translate-y-0': show }">
                <x-profile-card 
                    :name="$leaderName"
                    :title="$leaderTitle"
                    :image="$leaderImage"
                    :bio="$leaderBio"
                    :email="$leaderEmail"
                    :phone="$leaderPhone"
                    :linkedin="$leaderLinkedin"
                    layout="horizontal"
                />
            </div>
        </div>
    </section>
    @endif

    <!-- Message Content Section with Enhanced Typography -->
    <section class="py-12 md:py-20 bg-white relative overflow-hidden">
        {{-- Decorative Background Elements --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-[#E8F5E9]/20 rounded-full opacity-20 -translate-x-32 -translate-y-32"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#008236]/5 rounded-full opacity-20 translate-x-48 translate-y-48"></div>
        
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                {{-- Left Sidebar - Profile Image with Initial --}}
                @if($leaderName && $leaderImage)
                <div class="lg:w-64 flex-shrink-0">
                    <div class="sticky top-24">
                        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" 
                             class="opacity-0 transform translate-y-8 transition-all duration-1000 ease-out"
                             :class="{ 'opacity-100 translate-y-0': show }">
                            {{-- Profile Image with Initial Overlay --}}
                            <div class="relative w-48 h-48 lg:w-64 lg:h-64 mx-auto group">
                                {{-- Main Image --}}
                                <div class="w-full h-full rounded-3xl overflow-hidden shadow-2xl ring-4 ring-[#008236]/20 hover:ring-[#008236]/40 transition-all duration-500 hover:scale-105">
                                    <img 
                                        src="{{ $leaderImage }}" 
                                        alt="{{ $leaderName }}"
                                        class="w-full h-full object-cover"
                                        loading="lazy"
                                    >
                                </div>
                                
                                {{-- Initial Badge --}}
                                <div class="absolute -bottom-4 -right-4 w-20 h-20 lg:w-24 lg:h-24 bg-gradient-to-br from-[#008236] to-[#006a2b] rounded-2xl shadow-xl flex items-center justify-center ring-4 ring-white group-hover:scale-110 transition-transform duration-500">
                                    <span class="text-3xl lg:text-4xl font-bold text-white">
                                        {{ substr($leaderName, 0, 1) }}
                                    </span>
                                </div>
                                
                                {{-- Decorative Elements --}}
                                <div class="absolute -top-3 -left-3 w-16 h-16 bg-[#008236]/20 rounded-full blur-xl animate-float"></div>
                                <div class="absolute -bottom-3 -right-3 w-20 h-20 bg-[#7AB91E]/20 rounded-full blur-xl animate-float" style="animation-delay: 2s;"></div>
                            </div>
                            
                            {{-- Name & Title Below Image --}}
                            <div class="mt-8 text-center">
                                <h3 class="text-xl lg:text-2xl font-bold text-[#008236] mb-2">
                                    {{ $leaderName }}
                                </h3>
                                <p class="text-sm lg:text-base font-semibold text-gray-600">
                                    {{ $leaderTitle }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                {{-- Main Content Area --}}
                <div class="flex-1 min-w-0">
            @if($page->hasMedia('featured_image'))
            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" 
                 class="mb-12 opacity-0 transform translate-y-8 transition-all duration-1000 ease-out"
                 :class="{ 'opacity-100 translate-y-0': show }">
                @php
                    $featuredImage = $page->getMediaUrlRelative('featured_image', 'large');
                @endphp
                @if($featuredImage)
                <picture>
                    @php
                        $webpUrl = $page->getWebPMediaUrl('featured_image', 'large');
                    @endphp
                    @if($webpUrl)
                        <source srcset="{{ $webpUrl }}" type="image/webp">
                    @endif
                    <img 
                        src="{{ $featuredImage }}" 
                        alt="{{ $page->title }}"
                        class="w-full h-64 sm:h-80 md:h-96 object-cover rounded-3xl shadow-lg hover:shadow-xl transition-shadow duration-500" 
                        loading="lazy"
                    >
                </picture>
                @endif
            </div>
            @endif

                    {{-- Enhanced Content with Better Typography --}}
                    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)" 
                         class="leadership-content prose prose-base md:prose-lg prose-headings:font-display prose-headings:text-[#008236] prose-headings:font-bold prose-headings:tracking-tight prose-p:text-gray-700 prose-p:leading-relaxed prose-a:text-[#008236] prose-a:font-semibold prose-a:no-underline hover:prose-a:underline prose-strong:text-[#008236] prose-strong:font-bold prose-ul:text-gray-700 prose-ol:text-gray-700 prose-blockquote:border-l-4 prose-blockquote:border-[#008236] prose-blockquote:bg-[#E8F5E9] prose-blockquote:py-4 prose-blockquote:px-6 prose-blockquote:rounded-r-2xl prose-blockquote:not-italic prose-blockquote:text-gray-800 max-w-none opacity-0 transform translate-y-8 transition-all duration-1000 delay-300 ease-out"
                         :class="{ 'opacity-100 translate-y-0': show }">
                        {!! $page->content !!}
                    </div>

                    {{-- Signature Section --}}
                    @if($leaderName)
                    <div class="mt-12 pt-8 border-t-2 border-gray-200">
                        <div class="flex items-center gap-4">
                            <div>
                                <p class="text-lg font-bold text-aisd-midnight">{{ $leaderName }}</p>
                                <p class="text-sm text-gray-600">{{ $leaderTitle }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Call to Action Section --}}
                    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 700)" 
                         class="mt-12 md:mt-16 p-6 md:p-8 bg-gradient-to-br from-[#008236] to-[#006a2b] rounded-2xl md:rounded-3xl text-white text-center shadow-lg hover:shadow-xl transition-shadow duration-500 opacity-0 transform translate-y-8 transition-all duration-1000 delay-500 ease-out"
                         :class="{ 'opacity-100 translate-y-0': show }">
                        <h3 class="text-xl md:text-2xl lg:text-3xl font-bold mb-3 md:mb-4">Want to Learn More?</h3>
                        <p class="text-sm md:text-base text-white/90 mb-6 max-w-2xl mx-auto">
                            Discover more about our vision, mission, and the dedicated team working to provide excellence in Islamic education.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center">
                            <a href="{{ route('about.index') }}" class="inline-flex items-center justify-center rounded-xl bg-white px-6 md:px-8 py-3 md:py-4 text-sm md:text-base font-semibold text-[#008236] transition-all hover:bg-gray-100 hover:scale-105 min-h-[44px] shadow-md hover:shadow-lg">
                                About Our School
                                <svg class="ml-2 w-4 md:w-5 h-4 md:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                            <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center rounded-xl border-2 border-white px-6 md:px-8 py-3 md:py-4 text-sm md:text-base font-semibold text-white transition-all hover:bg-white/10 hover:scale-105 min-h-[44px]">
                                Contact Us
                            </a>
                        </div>
                    </div>

                    {{-- Page Actions --}}
                    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 700)" 
                         class="mt-12 pt-8 border-t border-gray-200 opacity-0 transform translate-y-8 transition-all duration-1000 delay-500 ease-out"
                         :class="{ 'opacity-100 translate-y-0': show }">
                        <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
                            <div class="text-sm text-gray-600">
                                Last updated: {{ $page->updated_at->format('F j, Y') }}
                            </div>
                            <div class="flex gap-4">
                                <button onclick="window.print()" class="inline-flex items-center justify-center rounded-xl border-2 border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 transition-all hover:border-gray-400 hover:bg-gray-50 hover:scale-105 min-h-[44px] shadow-sm hover:shadow-md">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    Print
                                </button>
                                <button onclick="sharePage()" class="inline-flex items-center justify-center rounded-xl border-2 border-[#008236] bg-[#008236] px-6 py-3 text-sm font-semibold text-white transition-all hover:bg-[#006a2b] hover:border-[#006a2b] hover:scale-105 min-h-[44px] shadow-lg hover:shadow-xl">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                    </svg>
                                    Share
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @media (prefers-reduced-motion: reduce) {
            .animate-float,
            [x-data] {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>

    <script>
        function sharePage() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $page->title }}',
                    text: '{{ Str::limit(strip_tags($page->content), 100) }}',
                    url: window.location.href,
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(function() {
                    alert('Page link copied to clipboard!');
                });
            }
        }
    </script>

@endsection
