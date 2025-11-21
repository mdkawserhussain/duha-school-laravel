<?php

namespace App\Filament\Pages;

use App\Models\HomePageSection;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use UnitEnum;

class HeroSliderManager extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected string $view = 'filament.pages.hero-slider-manager';

    protected static ?string $navigationLabel = 'Hero Slider';

    protected static ?string $title = 'Hero Slider Management';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 1;

    public $slides = [];
    public $editingSlide = null;
    public $showForm = false;
    public $previewSlide = null;
    public $image = null;
    public $videoPoster = null;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount(): void
    {
        $this->loadSlides();
    }

    public function loadSlides(): void
    {
        $this->slides = HomePageSection::where('section_type', 'hero')
            ->orderBy('sort_order')
            ->get()
            ->map(function ($slide) {
                $data = $slide->data ?? [];
                return [
                    'id' => $slide->id,
                    'title' => $slide->title,
                    'subtitle' => $slide->subtitle,
                    'description' => $slide->description,
                    'button_text' => $slide->button_text,
                    'button_link' => $slide->button_link,
                    'badge' => data_get($data, 'badge'),
                    'is_active' => $slide->is_active,
                    'sort_order' => $slide->sort_order,
                    'image_url' => $slide->getMediaUrl('images', 'large') ?: $slide->getMediaUrl('images'),
                    'video_url' => data_get($data, 'video_url'),
                    'video_poster' => $slide->getMediaUrl('video_poster', 'large') ?: $slide->getMediaUrl('video_poster'),
                    'secondary_button_text' => data_get($data, 'secondary_button_text'),
                    'secondary_button_link' => data_get($data, 'secondary_button_link'),
                    'features' => data_get($data, 'features', []),
                    'stats_cards' => data_get($data, 'stats_cards', []),
                    'stats_pills' => data_get($data, 'stats_pills', []),
                ];
            })
            ->toArray();
    }

    public function addNewSlide(): void
    {
        $this->editingSlide = [
            'title' => '',
            'subtitle' => '',
            'description' => '',
            'button_text' => '',
            'button_link' => '',
            'badge' => '',
            'is_active' => true,
            'video_url' => '',
            'secondary_button_text' => '',
            'secondary_button_link' => '',
            'features' => [],
            'stats_cards' => [],
            'stats_pills' => [],
        ];
        $this->showForm = true;
        $this->previewSlide = $this->editingSlide;
        $this->image = null;
        $this->videoPoster = null;
        $this->dispatch('refreshComponent');
    }

    public function editSlide($slideId): void
    {
        $slide = HomePageSection::find($slideId);
        if ($slide) {
            $data = $slide->data ?? [];
            $this->editingSlide = [
                'id' => $slide->id,
                'title' => $slide->title,
                'subtitle' => $slide->subtitle,
                'description' => $slide->description,
                'button_text' => $slide->button_text,
                'button_link' => $slide->button_link,
                'badge' => data_get($data, 'badge'),
                'is_active' => $slide->is_active,
                'sort_order' => $slide->sort_order,
                'image_url' => $slide->getMediaUrl('images', 'large') ?: $slide->getMediaUrl('images'),
                'video_url' => data_get($data, 'video_url'),
                'video_poster' => $slide->getMediaUrl('video_poster', 'large') ?: $slide->getMediaUrl('video_poster'),
                'secondary_button_text' => data_get($data, 'secondary_button_text'),
                'secondary_button_link' => data_get($data, 'secondary_button_link'),
                'features' => data_get($data, 'features', []),
                'stats_cards' => data_get($data, 'stats_cards', []),
                'stats_pills' => data_get($data, 'stats_pills', []),
            ];
            $this->showForm = true;
            $this->previewSlide = $this->editingSlide;
            $this->dispatch('refreshComponent');
        }
    }

    public function deleteSlide($slideId): void
    {
        $slide = HomePageSection::find($slideId);
        if ($slide) {
            $slide->delete();
            $this->loadSlides();
            $this->clearCache();

            Notification::make()
                ->title('Slide deleted successfully')
                ->success()
                ->send();
        }
    }

    public function duplicateSlide($slideId): void
    {
        $slide = HomePageSection::find($slideId);
        if ($slide) {
            $newSlide = $slide->replicate();
            $newSlide->section_key = 'hero_' . time();
            $newSlide->sort_order = HomePageSection::where('section_type', 'hero')->max('sort_order') + 1;
            $newSlide->save();

            // Copy media
            if ($slide->hasMedia('images')) {
                foreach ($slide->getMedia('images') as $media) {
                    $newSlide->addMedia($media->getPath())
                        ->toMediaCollection('images');
                }
            }

            $this->loadSlides();
            $this->clearCache();

            Notification::make()
                ->title('Slide duplicated successfully')
                ->success()
                ->send();
        }
    }

    public function previewSlide($slideId): void
    {
        $slide = HomePageSection::find($slideId);
        if ($slide) {
            $data = $slide->data ?? [];
            $this->previewSlide = [
                'title' => $slide->title,
                'subtitle' => $slide->subtitle,
                'description' => $slide->description,
                'button_text' => $slide->button_text,
                'button_link' => $slide->button_link,
                'badge' => data_get($data, 'badge'),
                'image_url' => $slide->getMediaUrl('images', 'large') ?: $slide->getMediaUrl('images'),
                'video_url' => data_get($data, 'video_url'),
                'video_poster' => $slide->getMediaUrl('video_poster', 'large') ?: $slide->getMediaUrl('video_poster'),
                'secondary_button_text' => data_get($data, 'secondary_button_text'),
                'secondary_button_link' => data_get($data, 'secondary_button_link'),
                'features' => data_get($data, 'features', []),
                'stats_cards' => data_get($data, 'stats_cards', []),
                'stats_pills' => data_get($data, 'stats_pills', []),
            ];
        }
    }

    public function updatePreview(): void
    {
        if ($this->editingSlide) {
            $this->previewSlide = $this->editingSlide;
        }
    }

    public function saveSlide(): void
    {
        $data = $this->editingSlide;

        if (isset($data['id'])) {
            $slide = HomePageSection::find($data['id']);
        } else {
            $slide = new HomePageSection();
            $slide->section_type = 'hero';
            $slide->section_key = 'hero_' . time();
            $slide->sort_order = HomePageSection::where('section_type', 'hero')->max('sort_order') + 1;
        }

        $slide->title = $data['title'] ?? null;
        $slide->subtitle = $data['subtitle'] ?? null;
        $slide->description = $data['description'] ?? null;
        $slide->button_text = $data['button_text'] ?? null;
        $slide->button_link = $data['button_link'] ?? null;
        $slide->is_active = $data['is_active'] ?? true;

        // Store all additional data in the data JSON field
        $slideData = $slide->data ?? [];
        if (isset($data['badge'])) {
            $slideData['badge'] = $data['badge'];
        }
        if (isset($data['video_url'])) {
            $slideData['video_url'] = $data['video_url'];
        }
        if (isset($data['secondary_button_text'])) {
            $slideData['secondary_button_text'] = $data['secondary_button_text'];
        }
        if (isset($data['secondary_button_link'])) {
            $slideData['secondary_button_link'] = $data['secondary_button_link'];
        }
        if (isset($data['features'])) {
            $slideData['features'] = $data['features'];
        }
        if (isset($data['stats_cards'])) {
            $slideData['stats_cards'] = $data['stats_cards'];
        }
        if (isset($data['stats_pills'])) {
            $slideData['stats_pills'] = $data['stats_pills'];
        }
        $slide->data = $slideData;

        $slide->save();

        // Handle image upload
        if ($this->image) {
            $slide->clearMediaCollection('images');
            $slide->addMedia($this->image)
                ->toMediaCollection('images');
            $this->image = null;
        }

        // Handle video poster upload
        if ($this->videoPoster) {
            $slide->clearMediaCollection('video_poster');
            $slide->addMedia($this->videoPoster)
                ->toMediaCollection('video_poster');
            $this->videoPoster = null;
        }

        $this->loadSlides();
        $this->clearCache();
        $this->showForm = false;
        $this->editingSlide = null;
        $this->previewSlide = null;

        Notification::make()
            ->title('Slide saved successfully')
            ->success()
            ->send();
    }

    public function updateSortOrder(array $order): void
    {
        foreach ($order as $index => $slideId) {
            HomePageSection::where('id', $slideId)
                ->update(['sort_order' => $index + 1]);
        }

        $this->loadSlides();
        $this->clearCache();

        Notification::make()
            ->title('Slide order updated')
            ->success()
            ->send();
    }

    public function toggleActive($slideId): void
    {
        $slide = HomePageSection::find($slideId);
        if ($slide) {
            $slide->is_active = !$slide->is_active;
            $slide->save();
            $this->loadSlides();
            $this->clearCache();
        }
    }

    protected function clearCache(): void
    {
        Cache::forget('homepage_v2_data');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('saveAll')
                ->label('Save All Changes')
                ->icon('heroicon-o-check')
                ->color('success')
                ->action(function () {
                    $this->clearCache();
                    Notification::make()
                        ->title('All changes saved and cache cleared')
                        ->success()
                        ->send();
                }),
        ];
    }
}

