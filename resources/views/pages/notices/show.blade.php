@extends('layouts.app')

@section('title', $notice->title . ' - Notices')
@section('meta-description', Str::limit(strip_tags($notice->content), 160))

@section('content')

    <!-- Page Header -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Notices', 'url' => route('notices.index')],
                ['label' => $notice->title, 'url' => null]
            ]" />

            <div class="max-w-4xl">
                @if($notice->category)
                <span class="inline-block bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full mb-4">
                    {{ $notice->category }}
                </span>
                @endif

                @if($notice->is_important)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 mb-4 ml-2">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    Important Notice
                </span>
                @endif

                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $notice->title }}</h1>

                <div class="flex items-center text-gray-600 mb-6">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Published {{ $notice->time_ago }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Notice Content -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    @if($notice->hasMedia('featured_image'))
                    <div class="mb-8">
                        @php
                            $featuredImage = $notice->getWebPMediaUrl('featured_image', 'large');
                            $originalImage = $notice->getFirstMediaUrl('featured_image');
                        @endphp
                        <picture>
                            @if($featuredImage)
                                <source srcset="{{ $featuredImage }}" type="image/webp">
                            @endif
                            <img src="{{ $originalImage }}" alt="{{ $notice->title }}" class="w-full h-64 md:h-80 object-cover rounded-lg shadow-lg" loading="lazy">
                        </picture>
                    </div>
                    @endif

                    <div class="prose prose-lg max-w-none">
                        {!! $notice->content !!}
                    </div>

                    <!-- Notice Actions -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('notices.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                                ← Back to Notices
                            </a>

                            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                                🖨️ Print Notice
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Social Sharing -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Share This Notice</h3>
                        <x-social-share 
                            :url="route('notices.show', ['notice' => $notice->slug])"
                            :title="$notice->title"
                            :description="Str::limit(strip_tags($notice->content), 160)"
                            :image="$notice->hasMedia('featured_image') ? $notice->getFirstMediaUrl('featured_image') : null"
                        />
                    </div>

                    <!-- Notice Details -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Notice Details</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Published Date</dt>
                                <dd class="text-sm text-gray-900 mt-1">{{ $notice->published_at->format('F j, Y') }}</dd>
                            </div>

                            @if($notice->category)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Category</dt>
                                <dd class="text-sm text-gray-900 mt-1">
                                    <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded">{{ $notice->category }}</span>
                                </dd>
                            </div>
                            @endif

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Priority</dt>
                                <dd class="text-sm text-gray-900 mt-1">
                                    @if($notice->is_important)
                                        <span class="text-red-600 font-medium">High Priority</span>
                                    @else
                                        <span class="text-gray-600">Normal</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Related Notices -->
                    @php
                        $relatedNotices = \App\Models\Notice::published()
                            ->where('id', '!=', $notice->id)
                            ->when($notice->category, function($query) use ($notice) {
                                return $query->where('category', $notice->category);
                            })
                            ->orderBy('published_at', 'desc')
                            ->limit(3)
                            ->get();
                    @endphp

                    @if($relatedNotices->count() > 0)
                    <div class="bg-blue-50 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Notices</h3>
                        <div class="space-y-3">
                            @foreach($relatedNotices as $related)
                                @if($related->slug)
                                <div class="border-l-4 border-blue-400 pl-4">
                                    <a href="{{ route('notices.show', ['notice' => $related->slug]) }}" class="text-blue-600 hover:text-blue-800 font-medium transition duration-300">
                                        {{ Str::limit($related->title, 50) }}
                                    </a>
                                    <p class="text-sm text-gray-600 mt-1">{{ $related->time_ago }}</p>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Contact Info -->
                    <div class="bg-green-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Questions?</h3>
                        <p class="text-gray-600 mb-4">If you have any questions about this notice, please contact the school administration.</p>
                        <div class="space-y-2">
                            <a href="tel:{{ str_replace([' ', '-'], '', config('contact.phone')) }}" class="flex items-center text-green-600 hover:text-green-800 transition duration-300">
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ config('contact.phone_display') }}
                            </a>
                            <a href="mailto:info@almaghribschool.com" class="flex items-center text-green-600 hover:text-green-800 transition duration-300">
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                info@almaghribschool.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection