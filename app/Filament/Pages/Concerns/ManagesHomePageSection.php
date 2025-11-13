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
                'image_url' => $section->getMediaUrl('images', 'large') ?: $section->getMediaUrl('images'),
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
                'image_url' => null,
            ];
        }

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
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

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

        // Handle image upload
        if (isset($data['image']) && is_array($data['image']) && !empty($data['image'])) {
            $section->clearMediaCollection('images');
            foreach ($data['image'] as $imagePath) {
                if (is_string($imagePath) && !filter_var($imagePath, FILTER_VALIDATE_URL)) {
                    if (str_starts_with($imagePath, 'livewire-tmp/')) {
                        $fullPath = storage_path('app/public/' . $imagePath);
                        if (file_exists($fullPath)) {
                            $section->addMedia($fullPath)->toMediaCollection('images');
                        }
                    } else {
                        $section->addMediaFromDisk($imagePath, 'public')->toMediaCollection('images');
                    }
                }
            }
        }

        $this->clearCache();

        Notification::make()
            ->title('Section saved successfully')
            ->success()
            ->send();
    }

    protected function clearCache(): void
    {
        Cache::forget('homepage_v2_data');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
    }
}

