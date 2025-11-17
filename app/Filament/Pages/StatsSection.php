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

class StatsSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Stats Section';

    protected static ?string $title = 'Stats Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 5;

    protected string $view = 'filament.pages.stats-section';

    protected function getSectionKey(): string
    {
        return 'stats_main';
    }

    protected function getSectionType(): string
    {
        return 'stats';
    }

    protected function getSectionTitle(): string
    {
        return 'Stats Section';
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
                            ->placeholder('Impact'),

                        FormComponents\TextInput::make('title')
                            ->label('Section Title')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Our School in Numbers'),

                        FormComponents\Textarea::make('description')
                            ->label('Section Description')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('A snapshot of growth across our Cambridge and Islamic streams.'),
                    ])
                    ->columns(1),

                Components\Section::make('Statistics')
                    ->schema([
                        FormComponents\Repeater::make('stats')
                            ->label('Stats')
                            ->schema([
                                FormComponents\TextInput::make('label')
                                    ->label('Label')
                                    ->required()
                                    ->maxLength(100)
                                    ->placeholder('e.g., Students, Teachers, Years'),
                                
                                FormComponents\TextInput::make('value')
                                    ->label('Value')
                                    ->required()
                                    ->maxLength(50)
                                    ->placeholder('e.g., 1200+, 85, 15+'),
                                
                                FormComponents\TextInput::make('copy')
                                    ->label('Description')
                                    ->required()
                                    ->maxLength(200)
                                    ->placeholder('e.g., Across Early Years to A-Level'),
                                
                                FormComponents\Textarea::make('icon')
                                    ->label('Icon SVG Path')
                                    ->required()
                                    ->maxLength(500)
                                    ->rows(2)
                                    ->placeholder('M13 6a3 3 0 11-6 0...')
                                    ->helperText('SVG path data for the icon'),
                            ])
                            ->defaultItems(4)
                            ->minItems(1)
                            ->maxItems(6)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => ($state['label'] ?? 'New Stat') . ': ' . ($state['value'] ?? ''))
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Components\Section::make('Call-to-Action Section')
                    ->schema([
                        FormComponents\TextInput::make('cta.title')
                            ->label('CTA Title')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Join a community grounded in faith and excellence.'),

                        FormComponents\TextInput::make('cta.button1.text')
                            ->label('Button 1 Text')
                            ->maxLength(100)
                            ->placeholder('Schedule a Visit'),

                        FormComponents\TextInput::make('cta.button1.link')
                            ->label('Button 1 Link')
                            ->maxLength(255)
                            ->url()
                            ->placeholder('#visit'),

                        FormComponents\TextInput::make('cta.button2.text')
                            ->label('Button 2 Text')
                            ->maxLength(100)
                            ->placeholder('Talk to Admissions'),

                        FormComponents\TextInput::make('cta.button2.link')
                            ->label('Button 2 Link')
                            ->maxLength(255)
                            ->url()
                            ->placeholder('#contact'),
                    ])
                    ->columns(2),

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

