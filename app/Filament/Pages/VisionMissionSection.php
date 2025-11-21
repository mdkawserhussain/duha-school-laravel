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

class VisionMissionSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-eye';

    protected static ?string $navigationLabel = 'Vision & Mission';

    protected static ?string $title = 'Vision & Mission Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 8;

    protected string $view = 'filament.pages.vision-mission-section';

    protected function getSectionKey(): string
    {
        return 'vision';
    }

    protected function getSectionType(): string
    {
        return 'vision_mission';
    }

    protected function getSectionTitle(): string
    {
        return 'Vision & Mission Section';
    }

    public function mount(): void
    {
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
            
            // Load existing campus image if available
            if ($section->hasMedia('images')) {
                $this->data['campus_image'] = $section->getFirstMediaUrl('images');
            }
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

        $this->form->fill($this->data);
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
        $section->subtitle = $data['subtitle'] ?? null;
        $section->description = $data['description'] ?? null;
        $section->content = $data['content'] ?? null;
        $section->button_text = $data['button_text'] ?? null;
        $section->button_link = $data['button_link'] ?? null;
        $section->is_active = $data['is_active'] ?? true;
        $section->sort_order = $data['sort_order'] ?? 0;
        
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
            'campus_image' => true, // Exclude campus_image from data JSON
        ]);
        
        $section->data = $sectionData;
        $section->section_key = $sectionKey;
        $section->section_type = $sectionType;
        
        $section->save();

        // Handle campus image upload specifically
        $campusImageData = $formState['campus_image'] ?? null;
        
        if ($campusImageData) {
            // Clear existing images when new ones are uploaded
            $section->clearMediaCollection('images');
            
            // Handle array of images (if multiple uploads)
            if (is_array($campusImageData)) {
                foreach ($campusImageData as $imagePath) {
                    if (!empty($imagePath)) {
                        $this->processImageUpload($section, $imagePath);
                    }
                }
            } 
            // Handle single image string
            elseif (is_string($campusImageData) && !empty($campusImageData)) {
                $this->processImageUpload($section, $campusImageData);
            }
            
            // Reload section to get fresh media relationship
            $section->refresh();
        }

        // Clear cache
        \Illuminate\Support\Facades\Cache::forget('homepage_v2_data');
        \Illuminate\Support\Facades\Artisan::call('view:clear');

        \Filament\Notifications\Notification::make()
            ->title('Section saved successfully')
            ->success()
            ->send();
    }

    protected function processImageUpload(\App\Models\HomePageSection $section, string $imagePath): void
    {
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
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
            
            if (!$added && \Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath)) {
                try {
                    $section->addMediaFromDisk($imagePath, 'public')->toMediaCollection('images');
                    $added = true;
                } catch (\Exception $e) {
                    \Log::error('Failed to add media from disk: ' . $e->getMessage());
                }
            }
        } else {
            // Handle files in vision-section directory or other paths
            $possiblePaths = [
                storage_path('app/public/' . $imagePath),
                storage_path('app/public/vision-section/' . basename($imagePath)),
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

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Section Badge & Heading')
                    ->icon('heroicon-o-tag')
                    ->description('Configure the section badge and main heading')
                    ->schema([
                        FormComponents\TextInput::make('badge_text')
                            ->label('Badge Text')
                            ->maxLength(100)
                            ->placeholder('Our Charter')
                            ->helperText('Small text displayed in the badge at the top')
                            ->columnSpan(1),

                        FormComponents\TextInput::make('heading_line1')
                            ->label('Heading Line 1')
                            ->maxLength(255)
                            ->placeholder('Empowering Minds,')
                            ->helperText('First line of the main heading')
                            ->columnSpan(1),

                        FormComponents\TextInput::make('heading_line2')
                            ->label('Heading Line 2')
                            ->maxLength(255)
                            ->placeholder('Enriching Hearts')
                            ->helperText('Second line of the main heading (highlighted)')
                            ->columnSpan(1),

                        FormComponents\Textarea::make('description')
                            ->label('Section Description')
                            ->maxLength(500)
                            ->rows(3)
                            ->placeholder('We follow the footsteps of Duha with a distinctly Islamic ethos...')
                            ->helperText('Brief description below the heading')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Components\Section::make('Vision Card')
                    ->icon('heroicon-o-star')
                    ->description('Configure the Vision card content')
                    ->schema([
                        FormComponents\TextInput::make('vision_title')
                            ->label('Vision Title')
                            ->maxLength(50)
                            ->default('Vision')
                            ->helperText('Title for the vision card')
                            ->columnSpan(1),

                        FormComponents\Textarea::make('vision_text')
                            ->label('Vision Statement')
                            ->required()
                            ->maxLength(500)
                            ->rows(3)
                            ->placeholder('To cultivate God-conscious learners who lead with integrity and scholarship across the globe.')
                            ->helperText('Your school\'s vision statement')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Components\Section::make('Mission Card')
                    ->icon('heroicon-o-bolt')
                    ->description('Configure the Mission card content')
                    ->schema([
                        FormComponents\TextInput::make('mission_title')
                            ->label('Mission Title')
                            ->maxLength(50)
                            ->default('Mission')
                            ->helperText('Title for the mission card')
                            ->columnSpan(1),

                        FormComponents\Textarea::make('mission_text')
                            ->label('Mission Statement')
                            ->required()
                            ->maxLength(500)
                            ->rows(3)
                            ->placeholder('Deliver Cambridge excellence infused with Qur\'anic sciences, Arabic, and service learning pathways.')
                            ->helperText('Your school\'s mission statement')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Components\Section::make('Feature Pills')
                    ->icon('heroicon-o-sparkles')
                    ->description('Add feature highlights displayed as pills below the cards')
                    ->schema([
                        FormComponents\Repeater::make('features')
                            ->label('Features')
                            ->schema([
                                FormComponents\TextInput::make('text')
                                    ->label('Feature Text')
                                    ->required()
                                    ->maxLength(100)
                                    ->placeholder('e.g., Cambridge Primary to A-Level'),
                            ])
                            ->defaultItems(3)
                            ->minItems(0)
                            ->maxItems(6)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['text'] ?? 'New Feature')
                            ->columnSpanFull()
                            ->helperText('Feature highlights displayed as pills'),
                    ])
                    ->columns(1),

                Components\Section::make('Campus Image Section')
                    ->icon('heroicon-o-photo')
                    ->description('Configure the campus image and overlay content')
                    ->schema([
                        FormComponents\FileUpload::make('campus_image')
                            ->label('Campus Image')
                            ->image()
                            ->directory('vision-section')
                            ->visibility('public')
                            ->disk('public')
                            ->imageEditor()
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                            ->helperText('Upload a campus image. Leave empty to use default.')
                            ->dehydrated(false)
                            ->columnSpanFull(),

                        FormComponents\TextInput::make('image_title')
                            ->label('Image Overlay Title')
                            ->maxLength(100)
                            ->placeholder('Our Campus')
                            ->helperText('Title displayed on the image')
                            ->columnSpan(1),

                        FormComponents\TextInput::make('image_subtitle')
                            ->label('Image Overlay Subtitle')
                            ->maxLength(100)
                            ->placeholder('Where tradition meets innovation')
                            ->helperText('Subtitle displayed on the image')
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Components\Section::make('Core Values Card')
                    ->icon('heroicon-o-heart')
                    ->description('Configure the floating core values card')
                    ->schema([
                        FormComponents\TextInput::make('values_title')
                            ->label('Values Card Title')
                            ->maxLength(50)
                            ->default('Core Values')
                            ->helperText('Title for the core values card')
                            ->columnSpanFull(),

                        FormComponents\Repeater::make('core_values')
                            ->label('Core Values')
                            ->schema([
                                FormComponents\TextInput::make('value')
                                    ->label('Value')
                                    ->required()
                                    ->maxLength(100)
                                    ->placeholder('e.g., Ihsan in every lesson'),
                            ])
                            ->defaultItems(3)
                            ->minItems(1)
                            ->maxItems(6)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['value'] ?? 'New Value')
                            ->columnSpanFull()
                            ->helperText('List of core values'),
                    ])
                    ->columns(1),

                Components\Section::make('Section Settings')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        FormComponents\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0)
                            ->columnSpan(1),

                        FormComponents\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }
}
