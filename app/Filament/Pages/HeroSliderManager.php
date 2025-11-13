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

    public function mount(): void
    {
        $this->loadSlides();
    }

    public function loadSlides(): void
    {
        $this->slides = HomePageSection::where('section_type', 'hero')
            ->active()
            ->ordered()
            ->get()
            ->map(function ($slide) {
                return [
                    'id' => $slide->id,
                    'title' => $slide->title,
                    'subtitle' => $slide->subtitle,
                    'description' => $slide->description,
                    'button_text' => $slide->button_text,
                    'button_link' => $slide->button_link,
                    'badge' => data_get($slide->data, 'badge'),
                    'is_active' => $slide->is_active,
                    'sort_order' => $slide->sort_order,
                    'image_url' => $slide->getMediaUrl('images', 'large') ?: $slide->getMediaUrl('images'),
                ];
            })
            ->toArray();
    }

    public function addNewSlide(): void
    {
        $this->editingSlide = null;
        $this->showForm = true;
        $this->previewSlide = null;
    }

    public function editSlide($slideId): void
    {
        $slide = HomePageSection::find($slideId);
        if ($slide) {
            $this->editingSlide = [
                'id' => $slide->id,
                'title' => $slide->title,
                'subtitle' => $slide->subtitle,
                'description' => $slide->description,
                'button_text' => $slide->button_text,
                'button_link' => $slide->button_link,
                'badge' => data_get($slide->data, 'badge'),
                'is_active' => $slide->is_active,
                'sort_order' => $slide->sort_order,
                'image_url' => $slide->getMediaUrl('images', 'large') ?: $slide->getMediaUrl('images'),
            ];
            $this->showForm = true;
            $this->previewSlide = $this->editingSlide;
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
            $this->previewSlide = [
                'title' => $slide->title,
                'subtitle' => $slide->subtitle,
                'description' => $slide->description,
                'button_text' => $slide->button_text,
                'button_link' => $slide->button_link,
                'badge' => data_get($slide->data, 'badge'),
                'image_url' => $slide->getMediaUrl('images', 'large') ?: $slide->getMediaUrl('images'),
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

        $slideData = $slide->data ?? [];
        if (isset($data['badge'])) {
            $slideData['badge'] = $data['badge'];
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

