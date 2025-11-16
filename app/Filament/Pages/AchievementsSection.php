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

class AchievementsSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationLabel = 'Achievements';

    protected static ?string $title = 'Achievements Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 4;

    protected string $view = 'filament.pages.achievements-section';

    protected function getSectionKey(): string
    {
        return 'achievements';
    }

    protected function getSectionType(): string
    {
        return 'achievements';
    }

    protected function getSectionTitle(): string
    {
        return 'Achievements Section';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make($this->getSectionTitle())
                    ->schema([
                        FormComponents\TextInput::make('title')
                            ->label('Section Title')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Recognising Our Learners'),

                        FormComponents\TextInput::make('subtitle')
                            ->label('Section Subtitle/Badge')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Highlights'),

                        FormComponents\Textarea::make('description')
                            ->label('Section Description')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('From Qur\'an recitation championships to Cambridge distinctions...'),

                        FormComponents\Repeater::make('achievements')
                            ->label('Achievements')
                            ->schema([
                                FormComponents\TextInput::make('title')
                                    ->label('Achievement Title')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., Cambridge Top Achievers'),
                                
                                FormComponents\Textarea::make('copy')
                                    ->label('Description')
                                    ->required()
                                    ->maxLength(500)
                                    ->rows(3)
                                    ->placeholder('Multiple "Top in Bangladesh" awards...'),
                                
                                FormComponents\TextInput::make('badge')
                                    ->label('Badge Text')
                                    ->required()
                                    ->maxLength(50)
                                    ->placeholder('e.g., IGCSE, Hifz, STEM, Leadership'),
                                
                                FormComponents\Textarea::make('icon')
                                    ->label('Icon SVG Path')
                                    ->required()
                                    ->maxLength(500)
                                    ->rows(3)
                                    ->placeholder('M9 12l2 2 4-4M7.835 4.697a3.42...')
                                    ->helperText('SVG path data for the icon'),
                                
                                FormComponents\TextInput::make('button_text')
                                    ->label('Button Text (Optional)')
                                    ->maxLength(50)
                                    ->placeholder('e.g., Learn More, View Details, Read More')
                                    ->helperText('Leave empty to hide the call-to-action button'),
                                
                                FormComponents\TextInput::make('link')
                                    ->label('Button Link (Optional)')
                                    ->url()
                                    ->maxLength(500)
                                    ->placeholder('https://example.com/page or /about')
                                    ->helperText('Internal link (e.g., /about) or external URL (e.g., https://example.com)'),
                            ])
                            ->defaultItems(4)
                            ->minItems(1)
                            ->maxItems(8)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => ($state['title'] ?? 'New Achievement') . ' - ' . ($state['badge'] ?? ''))
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

