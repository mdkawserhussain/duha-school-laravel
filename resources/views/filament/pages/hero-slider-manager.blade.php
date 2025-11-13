<x-filament-panels::page>
    @php
        $slidesData = $this->slides ?? [];
        $editingSlideData = $this->editingSlide ?? null;
        $previewSlideData = $this->previewSlide ?? null;
        $showFormData = ($this->editingSlide ?? null) || ($this->previewSlide ?? null);
        $slidesJson = json_encode($slidesData);
        $editingSlideJson = json_encode($editingSlideData);
        $previewSlideJson = json_encode($previewSlideData);
        $showFormJson = json_encode($showFormData);
        $hasNewImage = property_exists($this, 'image') && $this->image !== null;
        $editingId = is_array($editingSlideData) ? ($editingSlideData['id'] ?? null) : null;
        $existingSlide = null;
        $hasExistingImage = false;
        if ($editingId) {
            $existingSlide = \App\Models\HomePageSection::find($editingId);
            $hasExistingImage = $existingSlide && $existingSlide->hasMedia('images');
        }
    @endphp

    <div class="space-y-6" x-data="heroSliderManager()" x-init="init()">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Hero Slider Management</h2>
                <p class="text-sm text-gray-600 mt-1">Manage your homepage hero slider slides with drag-and-drop reordering</p>
            </div>
            <div class="flex gap-3">
                <button @click="addNewSlide()" class="fi-btn fi-btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New Slide
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="fi-card">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Slides</h3>
                        <p class="text-sm text-gray-600">Drag to reorder, click to edit</p>
                    </div>

                    <div id="slides-list" x-ref="slidesList" class="space-y-3">
                        <template x-for="(slide, index) in slides" :key="slide.id">
                            <div :data-id="slide.id" class="fi-draggable-item bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all" :class="{ 'opacity-50': slide.is_active === false }">
                                <div class="flex items-start gap-4">
                                    <div class="drag-handle cursor-move flex-shrink-0 mt-1">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <img :src="slide.image_url || '/images/placeholder.jpg'" :alt="slide.title" class="w-24 h-16 object-cover rounded-lg border border-gray-200" x-on:error="$el.src='/images/placeholder.jpg'" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h4 class="font-semibold text-gray-900" x-text="slide.title || 'Untitled Slide'"></h4>
                                                <p class="text-sm text-gray-600 mt-1" x-text="slide.subtitle || ''"></p>
                                                <div class="flex items-center gap-2 mt-2">
                                                    <span class="fi-badge" :class="slide.is_active ? 'fi-badge-success' : 'fi-badge-warning'" x-text="slide.is_active ? 'Active' : 'Inactive'"></span>
                                                    <span class="text-xs text-gray-500">Order: <span x-text="index + 1"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        <button @click="toggleActive(slide.id)" class="p-2 rounded-lg hover:bg-gray-100 transition-colors" :title="slide.is_active ? 'Deactivate' : 'Activate'">
                                            <svg class="w-5 h-5" :class="slide.is_active ? 'text-green-600' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </button>
                                        <button @click="editSlide(slide.id)" class="p-2 rounded-lg hover:bg-gray-100 transition-colors" title="Edit">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button @click="duplicateSlide(slide.id)" class="p-2 rounded-lg hover:bg-gray-100 transition-colors" title="Duplicate">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        </button>
                                        <button @click="previewSlide(slide.id)" class="p-2 rounded-lg hover:bg-gray-100 transition-colors" title="Preview">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                        <button @click="deleteSlide(slide.id)" class="p-2 rounded-lg hover:bg-red-100 transition-colors" title="Delete">
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div x-show="slides.length === 0" class="text-center py-12 text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p>No slides yet. Click "Add New Slide" to get started.</p>
                        </div>
                    </div>
                </div>

                <div x-show="showForm" x-transition class="fi-card">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900" x-text="editingSlide?.id ? 'Edit Slide' : 'Add New Slide'"></h3>
                    </div>

                    <form wire:submit.prevent="saveSlide" class="space-y-4">
                        <div>
                            <label class="fi-label">Slide Image</label>
                            <input type="file" wire:model="image" accept="image/jpeg,image/png,image/webp,image/gif" class="fi-input" />
                            <div wire:loading wire:target="image" class="mt-2">
                                <div class="fi-skeleton w-full h-48 rounded-lg"></div>
                            </div>
                            @if($hasNewImage)
                            <div class="mt-2" wire:loading.remove wire:target="image">
                                <img src="{{ $this->image->temporaryUrl() }}" alt="Preview" class="w-full h-48 object-cover rounded-lg border border-gray-200" />
                            </div>
                            @endif
                            @if($hasExistingImage)
                            <div class="mt-2" wire:loading.remove wire:target="image">
                                <img src="{{ $existingSlide->getMediaUrl('images', 'large') ?: $existingSlide->getMediaUrl('images') }}" alt="Current image" class="w-full h-48 object-cover rounded-lg border border-gray-200" />
                            </div>
                            @endif
                            @error('image')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="fi-label">Title</label>
                            <input type="text" wire:model.live="editingSlide.title" x-model="editingSlide.title" @input="updatePreview()" class="fi-input" placeholder="Enter slide title" />
                        </div>

                        <div>
                            <label class="fi-label">Subtitle</label>
                            <input type="text" wire:model.live="editingSlide.subtitle" x-model="editingSlide.subtitle" @input="updatePreview()" class="fi-input" placeholder="Enter slide subtitle (optional)" />
                        </div>

                        <div>
                            <label class="fi-label">Description</label>
                            <textarea wire:model.live="editingSlide.description" x-model="editingSlide.description" @input="updatePreview()" class="fi-input" rows="3" placeholder="Enter slide description"></textarea>
                        </div>

                        <div>
                            <label class="fi-label">Badge Text</label>
                            <input type="text" wire:model.live="editingSlide.badge" x-model="editingSlide.badge" @input="updatePreview()" class="fi-input" placeholder="Enter badge text (optional)" />
                        </div>

                        <div>
                            <label class="fi-label">Button Text</label>
                            <input type="text" wire:model.live="editingSlide.button_text" x-model="editingSlide.button_text" @input="updatePreview()" class="fi-input" placeholder="Enter button text" />
                        </div>

                        <div>
                            <label class="fi-label">Button Link</label>
                            <input type="url" wire:model.live="editingSlide.button_link" x-model="editingSlide.button_link" @input="updatePreview()" class="fi-input" placeholder="Enter button URL" />
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" wire:model.live="editingSlide.is_active" x-model="editingSlide.is_active" @change="updatePreview()" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                            <label class="fi-label mb-0">Active</label>
                        </div>

                        <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                            <button type="submit" class="fi-btn fi-btn-primary">Save Slide</button>
                            <button type="button" @click="showForm = false; editingSlide = null; previewSlide = null" class="fi-btn fi-btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="fi-preview-panel">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Live Preview</h3>
                        <p class="text-sm text-gray-600">See how your slide will look</p>
                    </div>

                    <div x-show="previewSlide" x-transition class="space-y-4">
                        <div class="relative h-64 rounded-lg overflow-hidden border border-gray-200">
                            <img :src="previewSlide.image_url || '/images/placeholder.jpg'" :alt="previewSlide.title" class="w-full h-full object-cover" x-on:error="$el.src='/images/placeholder.jpg'" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
                            <div class="absolute inset-0 flex items-center justify-center p-6">
                                <div class="text-center text-white">
                                    <div x-show="previewSlide.badge" class="mb-2">
                                        <span class="inline-block px-3 py-1 text-xs font-semibold uppercase tracking-wider bg-white/20 rounded-full" x-text="previewSlide.badge"></span>
                                    </div>
                                    <h3 class="text-2xl font-bold mb-2" x-text="previewSlide.title || 'Slide Title'"></h3>
                                    <p class="text-sm mb-4 opacity-90" x-text="previewSlide.description || 'Slide description'"></p>
                                    <div x-show="previewSlide.button_text">
                                        <a href="#" class="inline-block px-6 py-2 bg-white text-gray-900 rounded-lg font-medium hover:bg-gray-100 transition-colors" x-text="previewSlide.button_text"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show="!previewSlide" class="text-center py-12 text-gray-400">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <p>Select a slide to preview or start editing</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('heroSliderManager', () => ({
                slides: {!! $slidesJson !!},
                editingSlide: {!! $editingSlideJson !!},
                previewSlide: {!! $previewSlideJson !!},
                showForm: {!! $showFormJson !!},
                addNewSlide() {
                    this.editingSlide = { title: '', subtitle: '', button_text: '', button_link: '', is_active: true };
                    this.showForm = true;
                },
                editSlide(slideId) {
                    @this.editSlide(slideId);
                    this.$nextTick(() => {
                        this.editingSlide = this.$wire.get('editingSlide');
                        this.showForm = this.$wire.get('showForm');
                    });
                },
                deleteSlide(slideId) {
                    if (confirm('Are you sure you want to delete this slide?')) {
                        @this.deleteSlide(slideId);
                    }
                },
                duplicateSlide(slideId) {
                    @this.duplicateSlide(slideId);
                },
                previewSlide(slideId) {
                    @this.previewSlide(slideId);
                    this.$nextTick(() => {
                        this.previewSlide = this.$wire.get('previewSlide');
                    });
                },
                toggleActive(slideId) {
                    @this.toggleActive(slideId);
                },
                updatePreview() {
                    this.$nextTick(() => {
                        const preview = document.getElementById('live-preview');
                        if (preview) preview.innerHTML = preview.innerHTML;
                    });
                },
                init() {
                    this.$nextTick(() => {
                        const sortableEl = this.$refs.slidesList;
                        if (sortableEl && typeof Sortable !== 'undefined') {
                            Sortable.create(sortableEl, {
                                animation: 150,
                                handle: '.drag-handle',
                                onEnd: (evt) => {
                                    const order = Array.from(evt.to.children).map(el => parseInt(el.dataset.id)).filter(id => !isNaN(id));
                                    if (order.length > 0) {
                                        @this.updateSortOrder(order);
                                    }
                                }
                            });
                        }
                    });
                }
            }));
        });
    </script>
    @endpush
</x-filament-panels::page>
