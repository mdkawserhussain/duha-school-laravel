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

    protected static ?string $navigationLabel = 'Competitions';

    protected static ?string $title = 'Competition Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 6;

    protected string $view = 'filament.pages.competition-section';

    protected function getSectionKey(): string
    {
        return 'competitions';
    }

    protected function getSectionType(): string
    {
        return 'competitions';
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
                            ->label('Section Title')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Excellence in Academic & Islamic Pursuits'),

                        FormComponents\TextInput::make('data.badge')
                            ->label('Badge Text')
                            ->maxLength(100)
                            ->columnSpanFull()
                            ->placeholder('e.g., Achievements')
                            ->helperText('Small badge text displayed above the section title'),

                        FormComponents\Textarea::make('description')
                            ->label('Section Description')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Celebrating our students\' achievements in tournaments, Olympiads, and Qur\'anic competitions...'),

                        FormComponents\Repeater::make('data.competitions')
                            ->label('Competitions')
                            ->schema([
                                FormComponents\TextInput::make('badge')
                                    ->label('Badge Text')
                                    ->maxLength(100)
                                    ->placeholder('e.g., Achievement 1, Gold Medal, Champion')
                                    ->helperText('Small badge shown on the card'),

                                FormComponents\TextInput::make('title')
                                    ->label('Competition Title')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., Arabic Oratory League'),
                                
                                FormComponents\Textarea::make('copy')
                                    ->label('Description')
                                    ->required()
                                    ->maxLength(500)
                                    ->rows(3)
                                    ->placeholder('Students deliver khutbah-style speeches...'),
                                
                                FormComponents\TextInput::make('gradient')
                                    ->label('Gradient CSS')
                                    ->maxLength(255)
                                    ->placeholder('linear-gradient(135deg, #173B7A, #0F224C)')
                                    ->helperText('CSS gradient string for top bar'),
                                
                                FormComponents\TextInput::make('iconBg')
                                    ->label('Icon Background Color')
                                    ->maxLength(7)
                                    ->placeholder('#173B7A')
                                    ->helperText('Hex color for icon background'),
                                
                                FormComponents\Textarea::make('icon')
                                    ->label('Icon SVG Path')
                                    ->maxLength(500)
                                    ->rows(2)
                                    ->placeholder('M8 12h.01M12 12h.01M16 12h.01M21 12c0...')
                                    ->helperText('SVG path data for the icon'),
                            ])
                            ->defaultItems(3)
                            ->minItems(1)
                            ->maxItems(6)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'New Competition')
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

