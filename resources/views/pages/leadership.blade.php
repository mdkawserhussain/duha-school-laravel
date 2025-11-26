@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta-description', $page->meta_description)

@section('content')

@php
    // Extract profile data from page metadata
    $profileData = $page->metadata ?? [];
    $leaderName = $profileData['leader_name'] ?? 'Hasan Mahmud';
    $leaderTitle = $profileData['leader_title'] ?? 'Founder & President';
    $leaderImage = $page->hasMedia('profile_image') 
        ? $page->getFirstMediaUrl('profile_image', 'medium') 
        : ($profileData['leader_image'] ?? asset('images/placeholder.svg'));
    $signatureImage = $profileData['signature_image'] ?? null;
    $heroSubtitle = $profileData['hero_subtitle'] ?? null;
    
    // Split title to highlight last word in green
    $titleParts = explode(' ', $page->title);
    $lastWord = array_pop($titleParts);
    $firstPart = implode(' ', $titleParts);
@endphp

{{-- Hero Section with Profile Image --}}
<section class="relative pt-48 lg:pt-52 pb-16 lg:pb-20 overflow-visible min-h-[500px] lg:min-h-[600px]" style="background-color: #f9f9f5;">
    {{-- Decorative Green Shape at Top - Fully Visible Below Header --}}
    <div class="absolute left-0 pointer-events-none" style="top: 100px; width: 100%; height: 180px; z-index: 1;">
        <svg viewBox="0 0 1440 180" preserveAspectRatio="none" class="w-full h-full">
            <path d="M0,40 Q360,130 720,85 Q1080,35 1440,75 L1440,0 L0,0 Z" fill="#bcfbd1" opacity="0.7"></path>
            <path d="M0,30 Q360,110 720,70 Q1080,25 1440,60 L1440,0 L0,0 Z" fill="#bcfbd1" opacity="0.5"></path>
        </svg>
    </div>
    
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 relative z-10">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-10 lg:gap-16">
            
            {{-- Left: Title and Subtitle --}}
            <div class="flex-1 text-center lg:text-left fade-in">
                <h1 class="text-4xl lg:text-5xl font-bold mb-4" style="font-family: 'Playfair Display', serif; color: #1a1a1a;">
                    @if($firstPart)
                        {{ $firstPart }} <span style="color: #0d5a47;">{{ $lastWord }}</span>
                    @else
                        <span style="color: #0d5a47;">{{ $lastWord }}</span>
                    @endif
                </h1>
                
                <p class="text-base text-gray-600 max-w-xl leading-relaxed">
                    A few words from our Chairman reflecting the vision, mission, and values of Zaitoon Academy.
                </p>
            </div>
            
            {{-- Right: Profile Image --}}
            <div class="flex-shrink-0 zoom-in">
                <div class="relative bg-gradient-to-b from-gray-100 to-gray-200 rounded-2xl p-1" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
                    <img 
                        src="{{ $leaderImage }}" 
                        alt="{{ $leaderName }}"
                        class="w-[280px] h-[320px] lg:w-[320px] lg:h-[380px] object-cover object-top rounded-2xl"
                        style="background: linear-gradient(to bottom, #f5f5f5, #e8e8e8);"
                        loading="eager"
                        onerror="this.style.background='linear-gradient(to bottom, #f5f5f5, #e8e8e8)'; this.style.display='block';"
                    >
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Main Content Section --}}
<section class="py-12 lg:py-16" style="background-color: #f5f5f0;">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Profile Name & Title Card --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6 text-center slide-up">
            <h2 class="text-2xl font-bold mb-1" style="color: #0d5a47;">
                {{ $leaderName }}
            </h2>
            <p class="text-sm text-gray-600">
                {{ $leaderTitle }}
            </p>
        </div>
        
        {{-- Main Content --}}
        <article class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 lg:p-10 slide-up">
            
            {{-- Content --}}
            <div class="prose prose-lg max-w-none leadership-content">
                {!! $page->content !!}
            </div>
            
            {{-- Signature Section --}}
            @if($signatureImage || $leaderName)
            <div class="mt-12 pt-8 fade-in" style="border-top: 1px solid #e5e5e5;">
                @if($signatureImage)
                <img 
                    src="{{ $signatureImage }}" 
                    alt="Signature"
                    class="w-48 h-auto mb-3"
                    loading="lazy"
                >
                @endif
                
                <p class="text-lg font-bold mb-1" style="color: #0d5a47;">
                    {{ $leaderName }}
                </p>
                <p class="text-sm text-gray-600">
                    {{ $leaderTitle }}
                </p>
                <p class="text-sm font-semibold mt-1" style="color: #0d5a47;">
                    Zaitoon Academy
                </p>
                <p class="text-sm text-gray-600">
                    Chittagong, Bangladesh
                </p>
            </div>
            @endif
            
            {{-- Page Actions --}}
            <div class="mt-12 pt-8 border-t border-gray-200 fade-in">
                <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
                    <div class="text-sm text-gray-500">
                        Last updated: {{ $page->updated_at->format('F j, Y') }}
                    </div>
                    <div class="flex gap-3">
                        <button 
                            onclick="window.print()" 
                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-all hover:bg-gray-50">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Print
                        </button>
                        <button 
                            onclick="sharePage()" 
                            class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium text-white transition-all"
                            style="background-color: #0d5a47;"
                            onmouseover="this.style.backgroundColor='#0a4536'"
                            onmouseout="this.style.backgroundColor='#0d5a47'">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                            Share
                        </button>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>

<style>
/* Leadership Content Styling */
.leadership-content {
    color: #374151;
    font-size: 1rem;
    line-height: 1.75;
}

.leadership-content h2,
.leadership-content h3,
.leadership-content h4 {
    color: #0d5a47;
    font-weight: bold;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.leadership-content h2 {
    font-size: 1.5rem;
}

.leadership-content h3 {
    font-size: 1.25rem;
}

.leadership-content p {
    margin-bottom: 1rem;
    text-align: justify;
}

.leadership-content strong {
    color: #0d5a47;
    font-weight: 700;
}

.leadership-content blockquote {
    background: #f9f9f9;
    border-left: 4px solid #0d5a47;
    padding: 1.5rem;
    margin: 2rem 0;
    border-radius: 0 0.5rem 0.5rem 0;
    font-style: italic;
    color: #0d5a47;
}

.leadership-content ul,
.leadership-content ol {
    margin-left: 1.5rem;
    margin-bottom: 1rem;
}

.leadership-content li {
    margin-bottom: 0.5rem;
}

.leadership-content a {
    color: #0d5a47;
    font-weight: 600;
    text-decoration: none;
}

.leadership-content a:hover {
    text-decoration: underline;
}

/* Print Styles */
@media print {
    button,
    nav {
        display: none !important;
    }
    
    .leadership-content {
        font-size: 12pt;
    }
}

/* Responsive */
@media (max-width: 1024px) {
    .leadership-content {
        font-size: 0.9375rem;
    }
}
</style>

<script>
function sharePage() {
    if (navigator.share) {
        navigator.share({
            title: {{ Js::from($page->title) }},
            text: {{ Js::from(Str::limit(strip_tags($page->content), 100)) }},
            url: window.location.href,
        }).catch(err => console.log('Error sharing:', err));
    } else {
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert('Page link copied to clipboard!');
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
        });
    }
}
</script>

@endsection
