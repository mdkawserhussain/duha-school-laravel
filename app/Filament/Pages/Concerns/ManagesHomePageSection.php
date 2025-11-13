<?php

namespace App\Filament\Pages\Concerns;

use App\Models\HomePageSection;
use Filament\Forms\Components as FormComponents;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

trait ManagesHomePageSection
{
    use InteractsWithForms;

    public ?array $data = [];
    public $image = null;

    abstract protected function getSectionKey(): string;
    abstract protected function getSectionType(): string;
    abstract protected function getSectionTitle(): string;

    public function mount(): void
    {
        $section = HomePageSection::where('section_key', $this->getSectionKey())->first();

        if ($section) {
            $this->data = [
                'title' => $section->title,
                'subtitle' => $section->subtitle,
                'description' => $section->description,
                'content' => $section->content,
                'button_text' => $section->button_text,
                'button_link' => $section->button_link,
                'is_active' => $section->is_active,
                'sort_order' => $section->sort_order,
                'data' => $section->data ?? [],
            ];
        } else {
            $this->data = [
                'title' => null,
                'subtitle' => null,
                'description' => null,
                'content' => null,
                'button_text' => null,
                'button_link' => null,
                'is_active' => true,
                'sort_order' => 0,
                'data' => [],
            ];
        }

        // Don't populate image field - it's handled by Spatie Media Library
        $this->form->fill($this->data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make($this->getSectionTitle())
                    ->schema([
                        FormComponents\TextInput::make('title')
                            ->label('Title')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        FormComponents\TextInput::make('subtitle')
                            ->label('Subtitle')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        FormComponents\Textarea::make('description')
                            ->label('Description')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull(),

                        FormComponents\RichEditor::make('content')
                            ->label('Content')
                            ->columnSpanFull()
                            ->helperText('HTML content for this section'),

                        FormComponents\TextInput::make('button_text')
                            ->label('Button Text')
                            ->maxLength(100),

                        FormComponents\TextInput::make('button_link')
                            ->label('Button Link')
                            ->maxLength(255)
                            ->url(),

                        FormComponents\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0),

                        FormComponents\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),

                Components\Section::make('Media')
                    ->schema([
                        FormComponents\FileUpload::make('image')
                            ->label('Image')
                            ->image()
                            ->directory('homepage-sections')
                            ->visibility('public')
                            ->disk('public')
                            ->imageEditor()
                            ->maxSize(51200)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/jpg'])
                            ->helperText('Upload an image for this section')
                            ->dehydrated(false)
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $formState = $this->form->getRawState();

        $section = HomePageSection::where('section_key', $this->getSectionKey())->first();

        if (!$section) {
            $section = new HomePageSection();
            $section->section_key = $this->getSectionKey();
            $section->section_type = $this->getSectionType();
        }

        $section->title = $data['title'] ?? null;
        $section->subtitle = $data['subtitle'] ?? null;
        $section->description = $data['description'] ?? null;
        $section->content = $data['content'] ?? null;
        $section->button_text = $data['button_text'] ?? null;
        $section->button_link = $data['button_link'] ?? null;
        $section->is_active = $data['is_active'] ?? true;
        $section->sort_order = $data['sort_order'] ?? 0;
        $section->data = $data['data'] ?? [];

        $section->save();

        // Handle image upload from form state
        // Filament FileUpload stores files in the raw state
        $imageData = $formState['image'] ?? null;
        
        if ($imageData) {
            // Clear existing images when new ones are uploaded
            $section->clearMediaCollection('images');
            
            // Handle array of images (if multiple uploads)
            if (is_array($imageData)) {
                foreach ($imageData as $imagePath) {
                    if (!empty($imagePath)) {
                        $this->processImageUpload($section, $imagePath);
                    }
                }
            } 
            // Handle single image string
            elseif (is_string($imageData) && !empty($imageData)) {
                $this->processImageUpload($section, $imageData);
            }
            
            // Reload section to get fresh media relationship
            $section->refresh();
        }

        $this->clearCache();

        Notification::make()
            ->title('Section saved successfully')
            ->success()
            ->send();
    }

    protected function processImageUpload(HomePageSection $section, string $imagePath): void
    {
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            // Skip URLs
            return;
        }

        $added = false;

        // Handle Livewire temporary files
        if (str_starts_with($imagePath, 'livewire-tmp/')) {
            $fullPath = storage_path('app/public/' . $imagePath);
            if (file_exists($fullPath) && is_file($fullPath)) {
                try {
                    $section->addMedia($fullPath)->toMediaCollection('images');
                    $added = true;
                } catch (\Exception $e) {
                    \Log::error('Failed to add media from livewire-tmp: ' . $e->getMessage());
                }
            }
            
            // Also try using Storage disk
            if (!$added && \Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath)) {
                try {
                    $section->addMediaFromDisk($imagePath, 'public')->toMediaCollection('images');
                    $added = true;
                } catch (\Exception $e) {
                    \Log::error('Failed to add media from disk: ' . $e->getMessage());
                }
            }
        } else {
            // Handle files in homepage-sections directory or other paths
            $possiblePaths = [
                storage_path('app/public/' . $imagePath),
                storage_path('app/public/homepage-sections/' . basename($imagePath)),
                storage_path('app/' . $imagePath),
                public_path('storage/' . $imagePath),
                $imagePath,
            ];
            
            foreach ($possiblePaths as $testPath) {
                if (file_exists($testPath) && is_file($testPath)) {
                    try {
                        $section->addMedia($testPath)->toMediaCollection('images');
                        $added = true;
                        break;
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }
            
            // Try Storage disk as fallback
            if (!$added && \Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath)) {
                try {
                    $section->addMediaFromDisk($imagePath, 'public')->toMediaCollection('images');
                    $added = true;
                } catch (\Exception $e) {
                    \Log::error('Failed to add media from storage disk: ' . $e->getMessage());
                }
            }
        }
    }

    protected function clearCache(): void
    {
        Cache::forget('homepage_v2_data');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
    }
}

