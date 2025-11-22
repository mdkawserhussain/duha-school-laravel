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

class ProgramsSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Programs Section';

    protected static ?string $title = 'Academic Programs Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.pages.programs-section';

    protected function getSectionKey(): string
    {
        return 'academic_programs';
    }

    protected function getSectionType(): string
    {
        return 'programs';
    }

    protected function getSectionTitle(): string
    {
        return 'Academic Programs Section';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Section Header')
                    ->schema([
                        FormComponents\TextInput::make('subtitle')
                            ->label('Section Badge/Subtitle')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Academic Excellence'),

                        FormComponents\TextInput::make('title')
                            ->label('Section Title')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Our Academic Programs'),

                        FormComponents\Textarea::make('description')
                            ->label('Section Description')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Comprehensive educational pathways designed to nurture...'),
                    ])
                    ->columns(1),

                Components\Section::make('Academic Programs')
                    ->schema([
                        FormComponents\Repeater::make('programs')
                            ->label('Programs')
                            ->schema([
                                FormComponents\TextInput::make('title')
                                    ->label('Program Title')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., Early Years, Primary Years, Secondary Years'),
                                
                                FormComponents\TextInput::make('grade_range')
                                    ->label('Grade Range')
                                    ->required()
                                    ->maxLength(100)
                                    ->placeholder('e.g., Kindergarten - Grade 2'),
                                
                                FormComponents\Textarea::make('description')
                                    ->label('Description')
                                    ->required()
                                    ->maxLength(500)
                                    ->rows(3)
                                    ->placeholder('Foundation learning through play-based activities...'),
                                
                                FormComponents\TextInput::make('icon_bg_color')
                                    ->label('Icon Background Color')
                                    ->maxLength(7)
                                    ->placeholder('#6EC1F5')
                                    ->helperText('Hex color for icon background'),
                                
                                FormComponents\Textarea::make('icon')
                                    ->label('Icon SVG Path')
                                    ->maxLength(500)
                                    ->rows(2)
                                    ->placeholder('M10.394 2.08a1 1 0 00-.788 0l-7 3...')
                                    ->helperText('SVG path data for the icon'),

                                FormComponents\Repeater::make('features')
                                    ->label('Features List')
                                    ->schema([
                                        FormComponents\TextInput::make('text')
                                            ->label('Feature Text')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g., Play-based Learning'),
                                    ])
                                    ->defaultItems(3)
                                    ->minItems(1)
                                    ->maxItems(10)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['text'] ?? 'New Feature')
                                    ->columnSpanFull(),
                            ])
                            ->defaultItems(3)
                            ->minItems(1)
                            ->maxItems(6)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => ($state['title'] ?? 'New Program') . ' - ' . ($state['grade_range'] ?? ''))
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Components\Section::make('Special Features Section')
                    ->schema([
                        FormComponents\TextInput::make('special_features.title')
                            ->label('Title')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Beyond Traditional Education'),

                        FormComponents\Textarea::make('special_features.description')
                            ->label('Description')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Our holistic approach ensures...'),

                        FormComponents\Repeater::make('special_features.features')
                            ->label('Feature Items')
                            ->schema([
                                FormComponents\Textarea::make('icon')
                                    ->label('Icon SVG Path')
                                    ->maxLength(500)
                                    ->rows(2)
                                    ->placeholder('M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1...')
                                    ->helperText('SVG path data for the icon'),
                                
                                FormComponents\TextInput::make('title')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(100)
                                    ->placeholder('e.g., Smart Classes'),
                                
                                FormComponents\TextInput::make('subtitle')
                                    ->label('Subtitle')
                                    ->maxLength(100)
                                    ->placeholder('e.g., Digital Learning'),
                            ])
                            ->defaultItems(4)
                            ->minItems(1)
                            ->maxItems(6)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => ($state['title'] ?? 'New Feature') . ' - ' . ($state['subtitle'] ?? ''))
                            ->columnSpanFull(),

                        FormComponents\TextInput::make('special_features.cta.text')
                            ->label('CTA Button Text')
                            ->maxLength(100)
                            ->placeholder('Schedule a Visit'),

                        FormComponents\TextInput::make('special_features.cta.link')
                            ->label('CTA Button Link')
                            ->maxLength(255)
                            ->url()
                            ->placeholder('#contact'),
                    ])
                    ->columns(1),

                Components\Section::make('Settings')
                    ->schema([
                        FormComponents\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0),

                        FormComponents\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }
}

