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

    <!-- Enhanced Hero Section with Decorative Elements -->
    @php
        $heroImage = $page->hasMedia('hero_image') 
            ? $page->getMediaUrlRelative('hero_image', 'large') 
            : null;
    @endphp

    <section class="relative py-16 md:py-24 overflow-hidden" style="background: linear-gradient(135deg, #0C1B3D 0%, #173B7A 50%, #2563EB 100%);">
        {{-- Decorative Background Pattern --}}
        <div class="absolute inset-0 opacity-10" style="background-image:url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;200&quot; height=&quot;200&quot; viewBox=&quot;0 0 200 200&quot;><g fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;><path d=&quot;M100 0l20 60-60 20 60 20-20 60-20-60-60-20 60-20z&quot; stroke=&quot;%23F4C430&quot; stroke-width=&quot;1&quot; opacity=&quot;.4&quot;/></g></svg>');"></div>
        
        {{-- Floating Decorative Elements --}}
        <div class="absolute top-10 right-10 w-32 h-32 bg-aisd-gold/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 left-10 w-40 h-40 bg-aisd-sky/20 rounded-full blur-3xl"></div>

        <div class="container relative z-10 mx-auto px-4 sm:px-6 lg:px-12">
            <div class="max-w-4xl mx-auto text-center">
                @if($page->hero_badge)
                <div class="inline-flex items-center gap-2 rounded-full px-4 py-2 mb-6 text-xs font-semibold uppercase tracking-wider bg-white/10 border border-white/20 text-white backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-aisd-gold"></span>
                    {{ $page->hero_badge }}
                </div>
                @endif

                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                    {{ $page->title }}
                </h1>

                @if($page->hero_subtitle)
                <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto leading-relaxed">
                    {{ $page->hero_subtitle }}
                </p>
                @endif
            </div>
        </div>
    </section>

    <!-- Profile Card Section -->
    @if($leaderName)
    <section class="py-8 md:py-12 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
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
    </section>
    @endif

    <!-- Message Content Section with Enhanced Typography -->
    <section class="py-12 md:py-20 bg-white relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                {{-- Left Sidebar - Profile Image with Initial --}}
                @if($leaderName && $leaderImage)
                <div class="lg:w-64 flex-shrink-0">
                    <div class="sticky top-24">
                        {{-- Profile Image with Initial Overlay --}}
                        <div class="relative w-48 h-48 lg:w-64 lg:h-64 mx-auto">
                            {{-- Main Image --}}
                            <div class="w-full h-full rounded-3xl overflow-hidden shadow-2xl ring-4 ring-aisd-gold/20">
                                <img 
                                    src="{{ $leaderImage }}" 
                                    alt="{{ $leaderName }}"
                                    class="w-full h-full object-cover"
                                    loading="lazy"
                                >
                            </div>
                            
                            {{-- Initial Badge --}}
                            <div class="absolute -bottom-4 -right-4 w-20 h-20 lg:w-24 lg:h-24 bg-gradient-to-br from-aisd-ocean to-aisd-cobalt rounded-2xl shadow-xl flex items-center justify-center ring-4 ring-white">
                                <span class="text-3xl lg:text-4xl font-bold text-white">
                                    {{ substr($leaderName, 0, 1) }}
                                </span>
                            </div>
                            
                            {{-- Decorative Elements --}}
                            <div class="absolute -top-3 -left-3 w-16 h-16 bg-aisd-gold/20 rounded-full blur-xl"></div>
                            <div class="absolute -bottom-3 -right-3 w-20 h-20 bg-aisd-sky/20 rounded-full blur-xl"></div>
                        </div>
                        
                        {{-- Name & Title Below Image --}}
                        <div class="mt-8 text-center">
                            <h3 class="text-xl lg:text-2xl font-bold text-aisd-midnight mb-2">
                                {{ $leaderName }}
                            </h3>
                            <p class="text-sm lg:text-base font-semibold text-aisd-ocean">
                                {{ $leaderTitle }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif
                
                {{-- Main Content Area --}}
                <div class="flex-1 min-w-0">
            @if($page->hasMedia('featured_image'))
            <div class="mb-12">
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
                        class="w-full h-64 sm:h-80 md:h-96 object-cover rounded-3xl shadow-2xl" 
                        loading="lazy"
                    >
                </picture>
                @endif
            </div>
            @endif

                    {{-- Enhanced Content with Better Typography --}}
                    <div class="leadership-content prose prose-base md:prose-lg prose-headings:font-display prose-headings:text-aisd-midnight prose-headings:font-bold prose-headings:tracking-tight prose-p:text-gray-700 prose-p:leading-relaxed prose-a:text-aisd-ocean prose-a:font-semibold prose-a:no-underline hover:prose-a:underline prose-strong:text-aisd-midnight prose-strong:font-bold prose-ul:text-gray-700 prose-ol:text-gray-700 prose-blockquote:border-l-4 prose-blockquote:border-aisd-gold prose-blockquote:bg-gray-50 prose-blockquote:py-4 prose-blockquote:px-6 prose-blockquote:rounded-r-2xl prose-blockquote:not-italic prose-blockquote:text-gray-800 max-w-none">
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
                    <div class="mt-12 md:mt-16 p-6 md:p-8 bg-gradient-to-br from-aisd-ocean to-aisd-cobalt rounded-2xl md:rounded-3xl text-white text-center">
                        <h3 class="text-xl md:text-2xl lg:text-3xl font-bold mb-3 md:mb-4">Want to Learn More?</h3>
                        <p class="text-sm md:text-base text-white/90 mb-6 max-w-2xl mx-auto">
                            Discover more about our vision, mission, and the dedicated team working to provide excellence in Islamic education.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center">
                            <a href="{{ route('about.index') }}" class="inline-flex items-center justify-center rounded-xl bg-white px-6 md:px-8 py-3 md:py-4 text-sm md:text-base font-semibold text-aisd-ocean transition-all hover:bg-gray-100 min-h-[44px]">
                                About Our School
                                <svg class="ml-2 w-4 md:w-5 h-4 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                            <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center rounded-xl border-2 border-white px-6 md:px-8 py-3 md:py-4 text-sm md:text-base font-semibold text-white transition-all hover:bg-white/10 min-h-[44px]">
                                Contact Us
                            </a>
                        </div>
                    </div>

                    {{-- Page Actions --}}
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
                            <div class="text-sm text-gray-600">
                                Last updated: {{ $page->updated_at->format('F j, Y') }}
                            </div>
                            <div class="flex gap-4">
                                <button onclick="window.print()" class="inline-flex items-center justify-center rounded-xl border-2 border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 transition-all hover:border-gray-400 hover:bg-gray-50 min-h-[44px]">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    Print
                                </button>
                                <button onclick="sharePage()" class="inline-flex items-center justify-center rounded-xl border-2 border-aisd-ocean bg-aisd-ocean px-6 py-3 text-sm font-semibold text-white transition-all hover:bg-aisd-cobalt hover:border-aisd-cobalt min-h-[44px]">
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
