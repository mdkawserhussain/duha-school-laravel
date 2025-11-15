<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\ManagesHomePageSection;
use BackedEnum;
use Filament\Forms\Components as FormComponents;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Pages\Page;
use UnitEnum;

class ParallaxSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Parallax Section';

    protected static ?string $title = 'Parallax Experience Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 7;

    protected string $view = 'filament.pages.parallax-section';

    protected function getSectionKey(): string
    {
        return 'parallax_experience';
    }

    protected function getSectionType(): string
    {
        return 'parallax';
    }

    protected function getSectionTitle(): string
    {
        return 'Parallax Experience Section';
    }

    public function mount(): void
    {
        // Call the trait's mount method logic
        $section = \App\Models\HomePageSection::where('section_key', $this->getSectionKey())->first();

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

        // Load existing background image URL if available
        if ($section && $section->hasMedia('background_image')) {
            $this->data['background_image'] = $section->getFirstMediaUrl('background_image');
        }

        // Fill the form with data
        $this->form->fill($this->data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make($this->getSectionTitle())
                    ->schema([
                        FormComponents\TextInput::make('badge')
                            ->label('Section Badge')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Experience'),

                        FormComponents\TextInput::make('title')
                            ->label('Main Heading')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Where tradition meets innovation every school day.'),

                        FormComponents\Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Borrowing Duha\'s parallax rhythm, this slice of campus life...'),

                        FormComponents\Repeater::make('feature_pills')
                            ->label('Feature Pills')
                            ->schema([
                                FormComponents\TextInput::make('text')
                                    ->label('Feature Text')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., Dedicated Musalla & Hifz Pods'),
                            ])
                            ->defaultItems(3)
                            ->minItems(1)
                            ->maxItems(6)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['text'] ?? 'New Feature')
                            ->columnSpanFull(),

                        FormComponents\TextInput::make('cta.text')
                            ->label('CTA Button Text')
                            ->maxLength(100)
                            ->placeholder('Explore Our Campus'),

                        FormComponents\TextInput::make('cta.link')
                            ->label('CTA Button Link')
                            ->maxLength(255)
                            ->url()
                            ->placeholder('#campus'),

                        FormComponents\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0),

                        FormComponents\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),

                Components\Section::make('Background Image')
                    ->description('Upload a background image for the parallax section. The image will be displayed with parallax scrolling effects.')
                    ->schema([
                        FormComponents\FileUpload::make('background_image')
                            ->label('Parallax Background Image')
                            ->image()
                            ->directory('homepage-sections/parallax')
                            ->visibility('public')
                            ->disk('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '21:9',
                                '4:3',
                            ])
                            ->maxSize(10240) // 10MB
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg'])
                            ->helperText('Recommended size: 1920x1080 pixels or larger. The image will be displayed with parallax scrolling effects (fixed background attachment).')
                            ->previewable()
                            ->downloadable()
                            ->openable()
                            ->dehydrated(false)
                            ->columnSpanFull()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // Store the image path in data when uploaded (for preview)
                                if ($state) {
                                    $data = $get('data') ?? [];
                                    if (!is_array($data)) {
                                        $data = [];
                                    }
                                    // Store the path temporarily for preview
                                    $data['background_image'] = $state;
                                    $set('data', $data);
                                }
                            }),

                        FormComponents\Toggle::make('use_default_image')
                            ->label('Use Default Image')
                            ->helperText('If enabled, the default parallax image will be used instead of the uploaded image.')
                            ->default(false)
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $data = $get('data') ?? [];
                                if (!is_array($data)) {
                                    $data = [];
                                }
                                $data['use_default_image'] = $state;
                                $set('data', $data);
                            })
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
        
        $section = \App\Models\HomePageSection::where('section_key', $sectionKey)->first();

        if (!$section) {
            $section = new \App\Models\HomePageSection();
            $section->section_key = $sectionKey;
            $section->section_type = $sectionType;
            $section->is_active = true;
            $section->sort_order = 0;
        }

        // Extract standard fields
        $section->title = $data['title'] ?? null;
        $section->is_active = $data['is_active'] ?? true;
        $section->sort_order = $data['sort_order'] ?? 0;
        
        // Everything else goes into data
        $sectionData = array_diff_key($data, [
            'title' => true,
            'is_active' => true,
            'sort_order' => true,
        ]);
        
        $section->data = $sectionData;
        $section->save();

        // Handle background image upload
        // Since we use statePath('data'), the background_image might be in formState['data']['background_image']
        $backgroundImagePath = $formState['data']['background_image'] ?? $formState['background_image'] ?? null;
        
        // Handle array (if multiple files or nested structure)
        if (is_array($backgroundImagePath)) {
            $backgroundImagePath = !empty($backgroundImagePath[0]) ? $backgroundImagePath[0] : null;
        }
        
        if ($backgroundImagePath && is_string($backgroundImagePath)) {
            // Clear existing background image
            $section->clearMediaCollection('background_image');
            
            // Process the upload
            $this->processBackgroundImageUpload($section, $backgroundImagePath);
            
            // Reload section to get fresh media relationship
            $section->refresh();
        }

        $this->clearCache();

        \Filament\Notifications\Notification::make()
            ->title('Parallax section saved successfully')
            ->success()
            ->send();
    }

    protected function processBackgroundImageUpload(\App\Models\HomePageSection $section, $imagePath): void
    {
        // Ensure imagePath is a string
        if (is_array($imagePath)) {
            $imagePath = !empty($imagePath[0]) ? $imagePath[0] : null;
        }
        
        if (!$imagePath || !is_string($imagePath)) {
            return;
        }
        
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            // Skip URLs (already uploaded)
            return;
        }

        $added = false;

        // Handle Livewire temporary files
        if (is_string($imagePath) && str_starts_with($imagePath, 'livewire-tmp/')) {
            $fullPath = storage_path('app/public/' . $imagePath);
            if (file_exists($fullPath) && is_file($fullPath)) {
                try {
                    $section->addMedia($fullPath)->toMediaCollection('background_image');
                    $added = true;
                } catch (\Exception $e) {
                    \Log::error('Failed to add background image from livewire-tmp: ' . $e->getMessage());
                }
            }
            
            if (!$added && \Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath)) {
                try {
                    $section->addMediaFromDisk($imagePath, 'public')->toMediaCollection('background_image');
                    $added = true;
                } catch (\Exception $e) {
                    \Log::error('Failed to add background image from disk: ' . $e->getMessage());
                }
            }
        } else {
            // Ensure imagePath is a string before using it in paths
            if (!is_string($imagePath)) {
                \Log::error('Background image path is not a string', ['type' => gettype($imagePath), 'value' => $imagePath]);
                return;
            }
            
            // Handle files in homepage-sections/parallax directory or other paths
            $possiblePaths = [
                storage_path('app/public/' . $imagePath),
                storage_path('app/public/homepage-sections/parallax/' . basename($imagePath)),
                storage_path('app/' . $imagePath),
                public_path('storage/' . $imagePath),
                $imagePath,
            ];
            
            foreach ($possiblePaths as $testPath) {
                if (file_exists($testPath) && is_file($testPath)) {
                    try {
                        $section->addMedia($testPath)->toMediaCollection('background_image');
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
                    $section->addMediaFromDisk($imagePath, 'public')->toMediaCollection('background_image');
                    $added = true;
                } catch (\Exception $e) {
                    \Log::error('Failed to add background image from storage disk: ' . $e->getMessage());
                }
            }
        }
    }

    protected function clearCache(): void
    {
        \Illuminate\Support\Facades\Cache::forget('homepage_v2_data');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
    }
}

