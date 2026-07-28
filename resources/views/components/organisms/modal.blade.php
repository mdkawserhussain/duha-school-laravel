{{-- Modal Component for Zaitoon Academy --}}
@props([
    'id' => 'modal',
    'size' => 'md',
    'title' => null,
    'showClose' => true
])

@php
    $sizeClasses = [
        'sm' => 'max-w-md',
        'md' => 'max-w-2xl',
        'lg' => 'max-w-4xl',
        'xl' => 'max-w-6xl',
        'full' => 'max-w-full mx-4'
    ];
    $maxWidth = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<div
    x-data="{ 
        open: false,
        openModal() {
            this.open = true;
            document.body.classList.add('overflow-hidden');
        },
        closeModal() {
            this.open = false;
            document.body.classList.remove('overflow-hidden');
        }
    }"
    @modal-open-{{ $id }}.window="openModal()"
    @modal-close-{{ $id }}.window="closeModal()"
    @keydown.escape.window="closeModal()"
    x-show="open"
    style="display: none;"
    class="fixed inset-0 z-50 overflow-y-auto"
    role="dialog"
    aria-modal="true"
    :aria-labelledby="'{{ $id }}-title'"
>
    {{-- Backdrop --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="closeModal()"
        class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm"
    ></div>

    {{-- Modal Container --}}
    <div class="flex items-center justify-center min-h-screen p-4">
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.away="closeModal()"
            class="relative w-full {{ $maxWidth }} bg-white rounded-2xl shadow-2xl overflow-hidden"
        >
            {{-- Header --}}
            @if($title || $showClose)
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-za-green-light">
                @if($title)
                <h3 id="{{ $id }}-title" class="text-xl font-bold text-za-green-primary">
                    {{ $title }}
                </h3>
                @endif
                
                @if($showClose)
                <button
                    @click="closeModal()"
                    class="p-2 rounded-lg hover:bg-white transition-colors text-gray-600 hover:text-za-green-primary"
                    aria-label="Close modal"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                @endif
            </div>
            @endif

            {{-- Body --}}
            <div class="px-6 py-6">
                {{ $slot }}
            </div>

            {{-- Footer (optional) --}}
            @isset($footer)
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $footer }}
            </div>
            @endisset
        </div>
    </div>
</div>

{{-- Usage Example:
<x-organisms.modal id="admission-form" size="lg" title="Admission Application">
    <form>...</form>
    <x-slot name="footer">
        <button @click="$dispatch('modal-close-admission-form')">Cancel</button>
    </x-slot>
</x-organisms.modal>

<!-- Trigger -->
<button @click="$dispatch('modal-open-admission-form')">Open Form</button>
--}}
