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

    protected static ?int $navigationSort = 3;

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
