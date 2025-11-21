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

class BoardMembersSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Board Members';

    protected static ?string $title = 'Board Members Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 9;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    protected string $view = 'filament.pages.board-members-section';

    protected function getSectionKey(): string
    {
        return 'board_management';
    }

    protected function getSectionType(): string
    {
        return 'board';
    }

    protected function getSectionTitle(): string
    {
        return 'Board of Management Section';
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

                        FormComponents\Repeater::make('members')
                            ->label('Board Members')
                            ->schema([
                                FormComponents\TextInput::make('name')
                                    ->label('Name')
                                    ->required()
                                    ->maxLength(255),
                                
                                FormComponents\TextInput::make('title')
                                    ->label('Title/Role')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., CHAIRMAN & PRINCIPAL'),
                                
                                FormComponents\TextInput::make('organization')
                                    ->label('Organization')
                                    ->maxLength(255)
                                    ->default('AL-MAGHRIB INTERNATIONAL SCHOOL'),
                                
                                FormComponents\Textarea::make('bio')
                                    ->label('Bio')
                                    ->maxLength(1000)
                                    ->rows(4)
                                    ->placeholder('Brief biography of the board member'),
                                
                                FormComponents\TextInput::make('photo_url')
                                    ->label('Photo URL')
                                    ->url()
                                    ->maxLength(500)
                                    ->placeholder('https://example.com/photo.jpg'),
                            ])
                            ->defaultItems(3)
                            ->minItems(1)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => ($state['name'] ?? 'New Member') . ' - ' . ($state['title'] ?? ''))
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

