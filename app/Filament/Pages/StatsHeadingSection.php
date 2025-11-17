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

class StatsHeadingSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Stats Heading';

    protected static ?string $title = 'Stats Heading Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 6;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    protected string $view = 'filament.pages.stats-heading-section';

    protected function getSectionKey(): string
    {
        return 'hero_stats';
    }

    protected function getSectionType(): string
    {
        return 'stats';
    }

    protected function getSectionTitle(): string
    {
        return 'Stats Heading Section';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Stats Configuration')
                    ->schema([
                        FormComponents\Repeater::make('stats')
                            ->label('Statistics')
                            ->schema([
                                FormComponents\TextInput::make('value')
                                    ->label('Value')
                                    ->required()
                                    ->maxLength(50)
                                    ->placeholder('e.g., 2012, 750+, 120+'),
                                
                                FormComponents\TextInput::make('label')
                                    ->label('Label')
                                    ->required()
                                    ->maxLength(100)
                                    ->placeholder('e.g., Founded, Students, Expert Faculty'),
                            ])
                            ->defaultItems(4)
                            ->minItems(1)
                            ->maxItems(10)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => ($state['value'] ?? null) . ' - ' . ($state['label'] ?? null))
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }
}

