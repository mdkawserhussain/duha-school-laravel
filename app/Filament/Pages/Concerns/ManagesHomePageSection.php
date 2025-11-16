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
            // Merge section data with standard fields for statePath('data') forms
            $this->data = array_merge([
                'title' => $section->title,
                'subtitle' => $section->subtitle,
                'description' => $section->description,
                'content' => $section->content,
                'button_text' => $section->button_text,
                'button_link' => $section->button_link,
                'is_active' => $section->is_active,
                'sort_order' => $section->sort_order,
            ], $section->data ?? []);
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

                        FormComponents\Select::make('data.icon')
                            ->label('Icon')
                            ->options([
                                'plus' => 'Plus',
                                'calendar' => 'Calendar',
                                'megaphone' => 'Megaphone',
                            ])
                            ->helperText('Icon to display for this info block')
                            ->default('plus'),

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

        $sectionKey = $this->getSectionKey();
        $sectionType = $this->getSectionType();
        
        // Validate section key and type are not empty
        if (empty($sectionKey) || empty($sectionType)) {
            throw new \Exception('Section key and type must not be empty. Key: ' . ($sectionKey ?? 'null') . ', Type: ' . ($sectionType ?? 'null'));
        }
        
        $section = HomePageSection::where('section_key', $sectionKey)->first();

        if (!$section) {
            $section = new HomePageSection();
            // Set required fields immediately
            $section->section_key = $sectionKey;
            $section->section_type = $sectionType;
            $section->is_active = true;
            $section->sort_order = 0;
            
            // Verify the model is using the correct table
            if ($section->getTable() !== 'home_page_sections') {
                throw new \Exception('Model is using wrong table: ' . $section->getTable() . ' instead of home_page_sections');
            }
        }

        // Handle data structure - if statePath is 'data', the form state IS the data
        // Otherwise, data is nested under 'data' key
        $sectionData = [];
        if (isset($data['data']) && is_array($data['data'])) {
            // Standard structure: data is nested
            $sectionData = $data['data'];
            $section->title = $data['title'] ?? null;
            $section->subtitle = $data['subtitle'] ?? null;
            $section->description = $data['description'] ?? null;
            $section->content = $data['content'] ?? null;
            $section->button_text = $data['button_text'] ?? null;
            $section->button_link = $data['button_link'] ?? null;
            $section->is_active = $data['is_active'] ?? true;
            $section->sort_order = $data['sort_order'] ?? 0;
        } else {
            // statePath('data') structure: form state is the data itself
            // Extract standard fields and put the rest in data
            $section->title = $data['title'] ?? null;
            $section->subtitle = $data['subtitle'] ?? null;
            $section->description = $data['description'] ?? null;
            $section->content = $data['content'] ?? null;
            $section->button_text = $data['button_text'] ?? null;
            $section->button_link = $data['button_link'] ?? null;
            $section->is_active = $data['is_active'] ?? true;
            $section->sort_order = $data['sort_order'] ?? null;
            
            // Everything else goes into data
            $sectionData = array_diff_key($data, [
                'title' => true,
                'subtitle' => true,
                'description' => true,
                'content' => true,
                'button_text' => true,
                'button_link' => true,
                'is_active' => true,
                'sort_order' => true,
            ]);
        }
        
        // Check if data actually changed before saving
        $originalData = $section->data ?? [];
        $dataChanged = json_encode($originalData) !== json_encode($sectionData) ||
                       $section->title !== ($data['title'] ?? $section->title) ||
                       $section->subtitle !== ($data['subtitle'] ?? $section->subtitle) ||
                       $section->description !== ($data['description'] ?? $section->description) ||
                       $section->content !== ($data['content'] ?? $section->content) ||
                       $section->button_text !== ($data['button_text'] ?? $section->button_text) ||
                       $section->button_link !== ($data['button_link'] ?? $section->button_link) ||
                       $section->is_active !== ($data['is_active'] ?? $section->is_active) ||
                       $section->sort_order !== ($data['sort_order'] ?? $section->sort_order);
        
        $section->data = $sectionData;
        
        // Always set required fields explicitly before saving
        $section->section_key = $this->getSectionKey();
        $section->section_type = $this->getSectionType();
        
        // Ensure defaults are set
        if (is_null($section->is_active)) {
            $section->is_active = true;
        }
        if (is_null($section->sort_order)) {
            $section->sort_order = 0;
        }
        
        // Validate required fields before saving
        if (empty($section->section_key) || empty($section->section_type)) {
            throw new \Exception('Section key and type are required. Key: ' . ($section->section_key ?? 'null') . ', Type: ' . ($section->section_type ?? 'null'));
        }
        
        // Ensure we're using the correct model instance
        if (!($section instanceof HomePageSection)) {
            throw new \Exception('Invalid model instance. Expected HomePageSection, got: ' . get_class($section));
        }
        
        // Handle image upload from form state - only if file actually changed
        // Filament FileUpload stores files in the raw state
        $imageData = $formState['image'] ?? null;
        $imageChanged = false;
        
        if ($imageData) {
            // Handle array of images (if multiple uploads)
            if (is_array($imageData)) {
                foreach ($imageData as $imagePath) {
                    if (!empty($imagePath) && is_string($imagePath) && !filter_var($imagePath, FILTER_VALIDATE_URL)) {
                        // Check if this is a new file
                        $existingMedia = $section->getFirstMedia('images');
                        if (!$existingMedia || !str_contains($existingMedia->getPath(), $imagePath)) {
                            if (!$imageChanged) {
                                // Clear existing images when new ones are uploaded
                                $section->clearMediaCollection('images');
                                $imageChanged = true;
                            }
                            $this->processImageUpload($section, $imagePath);
                        }
                    }
                }
            } 
            // Handle single image string
            elseif (is_string($imageData) && !empty($imageData) && !filter_var($imageData, FILTER_VALIDATE_URL)) {
                // Check if this is a new file
                $existingMedia = $section->getFirstMedia('images');
                if (!$existingMedia || !str_contains($existingMedia->getPath(), $imageData)) {
                    // Clear existing images when new ones are uploaded
                    $section->clearMediaCollection('images');
                    $this->processImageUpload($section, $imageData);
                    $imageChanged = true;
                }
            }
            
            // Reload section to get fresh media relationship only if image changed
            if ($imageChanged) {
                $section->refresh();
            }
        }
        
        // Only save if data actually changed
        if ($dataChanged || $imageChanged) {
            try {
                $section->save();
            } catch (\Exception $e) {
                \Log::error('Failed to save HomePageSection', [
                    'section_key' => $section->section_key,
                    'section_type' => $section->section_type,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }
            
            // Only clear cache if data actually changed
            $this->clearCache();
        }

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

