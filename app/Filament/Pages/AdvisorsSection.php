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

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Hidden - Advisors section uses SiteSettingsHelper instead
    }

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
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                
                                FormComponents\TextInput::make('title')
                                    ->label('Title/Role')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., Chair, Board of Governors')
                                    ->columnSpan(1),
                                
                                FormComponents\Textarea::make('description')
                                    ->label('Description')
                                    ->required()
                                    ->maxLength(500)
                                    ->rows(3)
                                    ->placeholder('e.g., Former Cambridge examiner & Islamic pedagogy researcher.')
                                    ->columnSpanFull(),
                                
                                FormComponents\TextInput::make('photo_url')
                                    ->label('Photo URL')
                                    ->url()
                                    ->maxLength(500)
                                    ->placeholder('https://example.com/photo.jpg')
                                    ->helperText('URL to the advisor\'s profile photo')
                                    ->columnSpanFull(),
                                
                                FormComponents\TextInput::make('linkedin_url')
                                    ->label('LinkedIn URL')
                                    ->url()
                                    ->maxLength(500)
                                    ->placeholder('https://linkedin.com/in/username')
                                    ->columnSpan(1),
                                
                                FormComponents\TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->maxLength(255)
                                    ->placeholder('advisor@example.com')
                                    ->columnSpan(1),
                                
                                FormComponents\TextInput::make('accent_color')
                                    ->label('Accent Color')
                                    ->maxLength(20)
                                    ->placeholder('#F4C430')
                                    ->helperText('Hex color code for the advisor\'s accent color (optional)')
                                    ->columnSpan(1),
                            ])
                            ->columns(2)
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

