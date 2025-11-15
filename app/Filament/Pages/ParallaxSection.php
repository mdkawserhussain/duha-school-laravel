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
            ])
            ->statePath('data');
    }
}

