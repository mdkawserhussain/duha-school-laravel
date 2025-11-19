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
                Components\Section::make('Section Settings')
                    ->description('Configure the advisors section heading and visibility')
                    ->schema([
                        FormComponents\TextInput::make('title')
                            ->label('Section Title')
                            ->default('Advisors & Board of Governors')
                            ->maxLength(255)
                            ->columnSpan(1),

                        FormComponents\TextInput::make('subtitle')
                            ->label('Section Subtitle')
                            ->default('Leadership')
                            ->maxLength(255)
                            ->columnSpan(1),

                        FormComponents\Textarea::make('description')
                            ->label('Section Description')
                            ->default('Distinguished scholars, Cambridge examiners, and community leaders steward our Islamic ethos and academic rigor.')
                            ->maxLength(500)
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Components\Section::make('Advisors')
                    ->description('Add and manage advisor profiles')
                    ->schema([
                        FormComponents\Repeater::make('advisors')
                            ->label('')
                            ->schema([
                                FormComponents\TextInput::make('name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Dr. John Doe')
                                    ->columnSpan(1),
                                
                                FormComponents\TextInput::make('title')
                                    ->label('Title/Role')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Chair, Board of Governors')
                                    ->columnSpan(1),

                                FormComponents\Textarea::make('description')
                                    ->label('Bio/Description')
                                    ->required()
                                    ->maxLength(500)
                                    ->rows(2)
                                    ->placeholder('Brief professional background...')
                                    ->columnSpanFull(),
                                
                                FormComponents\TextInput::make('photo_url')
                                    ->label('Photo URL')
                                    ->url()
                                    ->maxLength(500)
                                    ->placeholder('https://example.com/photo.jpg')
                                    ->columnSpan(1),
                                
                                FormComponents\TextInput::make('linkedin_url')
                                    ->label('LinkedIn')
                                    ->url()
                                    ->maxLength(500)
                                    ->placeholder('https://linkedin.com/in/username')
                                    ->columnSpan(1),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->minItems(1)
                            ->maxItems(10)
                            ->collapsible()
                            ->cloneable()
                            ->reorderable()
                            ->itemLabel(fn (array $state): ?string => 
                                !empty($state['name']) 
                                    ? $state['name'] . (!empty($state['title']) ? ' - ' . $state['title'] : '')
                                    : 'New Advisor'
                            )
                            ->columnSpanFull()
                            ->addActionLabel('Add Advisor'),
                    ]),

                Components\Section::make('Display Settings')
                    ->schema([
                        FormComponents\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first on the homepage')
                            ->columnSpan(1),

                        FormComponents\Toggle::make('is_active')
                            ->label('Show Section on Homepage')
                            ->default(true)
                            ->helperText('Toggle to show/hide this section')
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ])
            ->statePath('data');
    }
}

