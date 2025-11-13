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

class OurValuesSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Our Values';

    protected static ?string $title = 'Our Values Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 9;

    protected string $view = 'filament.pages.our-values-section';

    protected function getSectionKey(): string
    {
        return 'values';
    }

    protected function getSectionType(): string
    {
        return 'list';
    }

    protected function getSectionTitle(): string
    {
        return 'Our Values Section';
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

                        FormComponents\Textarea::make('description')
                            ->label('Description')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull(),

                        FormComponents\Repeater::make('values')
                            ->label('Values')
                            ->schema([
                                FormComponents\TextInput::make('value')
                                    ->label('Value')
                                    ->required()
                                    ->maxLength(100)
                                    ->placeholder('e.g., Tawheed & God Consciousness'),
                            ])
                            ->defaultItems(8)
                            ->minItems(1)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['value'] ?? 'New Value')
                            ->columnSpanFull(),

                        FormComponents\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0),

                        FormComponents\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }
}

