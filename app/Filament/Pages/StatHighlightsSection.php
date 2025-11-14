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

class StatHighlightsSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Stat Highlights';

    protected static ?string $title = 'Stat Highlights Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 6;

    protected string $view = 'filament.pages.stat-highlights-section';

    protected function getSectionKey(): string
    {
        return 'stat_highlights';
    }

    protected function getSectionType(): string
    {
        return 'stat_highlights';
    }

    protected function getSectionTitle(): string
    {
        return 'Stat Highlights Section';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Stat Highlights Configuration')
                    ->schema([
                        FormComponents\Repeater::make('highlights')
                            ->label('Highlights')
                            ->schema([
                                FormComponents\TextInput::make('value')
                                    ->label('Value')
                                    ->required()
                                    ->maxLength(100)
                                    ->placeholder('e.g., Cambridge | Edexcel, Hifzul Qur\'an, STEAM Labs'),
                                
                                FormComponents\TextInput::make('label')
                                    ->label('Label')
                                    ->required()
                                    ->maxLength(200)
                                    ->placeholder('e.g., Dual International Curriculum Tracks'),
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

