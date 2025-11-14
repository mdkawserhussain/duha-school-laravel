<?php

namespace App\Filament\Resources\HomePageSections\Schemas;

use Filament\Forms\Components as FormComponents;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;

class HomePageSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Section Information')
                    ->schema([
                        FormComponents\Select::make('section_key')
                            ->label('Section Key')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->options([
                                'hero' => 'Hero Section',
                                'info_enrollment' => 'Information Block: Enrollment News',
                                'info_events' => 'Information Block: Regular Events',
                                'info_notice' => 'Information Block: Notice Board',
                                'upcoming_events' => 'Upcoming Events Section',
                                'vision' => 'Vision Section',
                                'video_1' => 'Video 1 (Academic Director)',
                                'video_2' => 'Video 2 (Quran Competition)',
                                'why_choose' => 'Why Choose Al-Maghrib',
                                'children_responsibility' => 'Your Children, Our Responsibility',
                                'values' => 'Our Values',
                                'advisors' => 'Advisors Section',
                                'board_management' => 'Board of Management',
                                'achievements' => 'Achievements Section',
                                'stats_main' => 'Stats Section',
                                'parallax_experience' => 'Parallax Experience Section',
                                'competitions' => 'Competitions Section',
                                'academic_programs' => 'Academic Programs Section',
                            ])
                            ->helperText('Unique identifier for this section')
                            ->live()
                            ->afterStateUpdated(function ($set, $state) {
                                // Auto-set section type based on key
                                $typeMap = [
                                    'hero' => 'hero',
                                    'info_enrollment' => 'info_block',
                                    'info_events' => 'info_block',
                                    'info_notice' => 'info_block',
                                    'upcoming_events' => 'events',
                                    'vision' => 'content',
                                    'video_1' => 'video',
                                    'video_2' => 'video',
                                    'why_choose' => 'content',
                                    'children_responsibility' => 'content',
                                    'values' => 'list',
                                    'advisors' => 'advisors',
                                    'board_management' => 'board',
                                    'achievements' => 'achievements',
                                    'stats_main' => 'stats',
                                    'parallax_experience' => 'parallax',
                                    'competitions' => 'competitions',
                                    'academic_programs' => 'programs',
                                ];
                                $set('section_type', $typeMap[$state] ?? 'content');
                            }),

                        FormComponents\Select::make('section_type')
                            ->label('Section Type')
                            ->required()
                            ->options([
                                'hero' => 'Hero Section',
                                'info_block' => 'Information Block',
                                'events' => 'Events Section',
                                'content' => 'Content Section',
                                'video' => 'Video Section',
                                'list' => 'List Section (Values)',
                                'advisors' => 'Advisors Section',
                                'board' => 'Board of Management',
                                'achievements' => 'Achievements Section',
                                'stats' => 'Stats Section',
                                'parallax' => 'Parallax Section',
                                'competitions' => 'Competitions Section',
                                'programs' => 'Programs Section',
                            ])
                            ->helperText('Type of section')
                            ->disabled()
                            ->dehydrated(),

                        FormComponents\TextInput::make('title')
                            ->label('Title')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Main title for this section'),

                        FormComponents\TextInput::make('subtitle')
                            ->label('Subtitle')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Optional subtitle or secondary heading'),

                        FormComponents\Textarea::make('description')
                            ->label('Description')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Short description or plain text content for this section'),

                        FormComponents\RichEditor::make('content')
                            ->label('Content')
                            ->columnSpanFull()
                            ->helperText('HTML content for this section. For info blocks, this is the description text.'),

                        FormComponents\TextInput::make('button_text')
                            ->label('Button Text')
                            ->maxLength(100)
                            ->helperText('Text for call-to-action button (if applicable)'),

                        FormComponents\TextInput::make('button_link')
                            ->label('Button Link')
                            ->maxLength(255)
                            ->url()
                            ->helperText('URL for call-to-action button (if applicable)'),

                        FormComponents\Textarea::make('data')
                            ->label('Additional Data (JSON)')
                            ->helperText('JSON data for structured content. Examples: For values: {"values": ["Value 1", "Value 2"]}. For advisors: {"advisors": [{"name": "Name", "title": "Title"}]}. For videos: {"video_url": "https://...", "youtube_url": "https://..."}. For board: {"members": [{"name": "Name", "title": "Title"}]}. For images: {"image_url": "https://..."}')
                            ->rows(10)
                            ->columnSpanFull()
                            ->formatStateUsing(function ($state) {
                                if (is_array($state)) {
                                    return json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                                }
                                return $state ?? '';
                            })
                            ->dehydrateStateUsing(function ($state) {
                                if (is_string($state)) {
                                    $decoded = json_decode($state, true);
                                    return $decoded !== null ? $decoded : [];
                                }
                                return is_array($state) ? $state : [];
                            }),

                        FormComponents\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first'),

                        FormComponents\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Only active sections are displayed'),
                    ])
                    ->columns(2),

                Components\Section::make('Media')
                    ->schema([
                        FormComponents\FileUpload::make('images')
                            ->label('Images')
                            ->image()
                            ->multiple()
                            ->directory('homepage-sections')
                            ->visibility('public')
                            ->disk('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->dehydrated(false)
                            ->helperText('Upload images for this section. Images can be used in the section display.')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }
}
