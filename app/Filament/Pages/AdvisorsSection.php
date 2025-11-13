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

class AdvisorsSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Advisors';

    protected static ?string $title = 'Advisors Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.pages.advisors-section';

    protected function getSectionKey(): string
    {
        return 'advisors';
    }

    protected function getSectionType(): string
    {
        return 'advisors';
    }

    protected function getSectionTitle(): string
    {
        return 'Advisors Section';
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

                        FormComponents\Repeater::make('advisors')
                            ->label('Advisors')
                            ->schema([
                                FormComponents\TextInput::make('name')
                                    ->label('Name')
                                    ->required()
                                    ->maxLength(255),
                                
                                FormComponents\TextInput::make('title')
                                    ->label('Title/Role')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., CHIEF ADVISOR'),
                                
                                FormComponents\Textarea::make('description')
                                    ->label('Description')
                                    ->maxLength(500)
                                    ->rows(3)
                                    ->placeholder('e.g., Khateeb & Principal, Green Lane Masjid & Islamic Centre, London, UK'),
                                
                                FormComponents\TextInput::make('subtitle')
                                    ->label('Subtitle/Additional Info')
                                    ->maxLength(255)
                                    ->placeholder('e.g., Former Professor, University of Chittagong, Bangladesh'),
                                
                                FormComponents\TextInput::make('photo_url')
                                    ->label('Photo URL')
                                    ->url()
                                    ->maxLength(500)
                                    ->placeholder('https://example.com/photo.jpg'),
                            ])
                            ->defaultItems(3)
                            ->minItems(1)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => ($state['name'] ?? 'New Advisor') . ' - ' . ($state['title'] ?? ''))
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

