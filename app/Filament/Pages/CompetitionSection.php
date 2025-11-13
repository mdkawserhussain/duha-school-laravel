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

class CompetitionSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationLabel = 'Competition Section';

    protected static ?string $title = 'Competition Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 7;

    protected string $view = 'filament.pages.competition-section';

    protected function getSectionKey(): string
    {
        return 'video_2';
    }

    protected function getSectionType(): string
    {
        return 'video';
    }

    protected function getSectionTitle(): string
    {
        return 'Competition Section';
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

                        FormComponents\TextInput::make('youtube_url')
                            ->label('YouTube URL')
                            ->url()
                            ->maxLength(500)
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->helperText('Enter the YouTube video URL for the competition')
                            ->columnSpanFull(),

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

