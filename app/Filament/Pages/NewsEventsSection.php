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

class NewsEventsSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationLabel = 'Events-Notices';

    protected static ?string $title = 'Events-Notices Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 4;

    protected string $view = 'filament.pages.news-events-section';

    protected function getSectionKey(): string
    {
        return 'news_events';
    }

    protected function getSectionType(): string
    {
        return 'news_events';
    }

    protected function getSectionTitle(): string
    {
        return 'Events-Notices Section';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Section Settings')
                    ->description('Configure the news and events section heading and visibility')
                    ->schema([
                        FormComponents\TextInput::make('title')
                            ->label('Section Title')
                            ->default('Upcoming Events & Key Dates')
                            ->maxLength(255)
                            ->columnSpan(1),

                        FormComponents\TextInput::make('subtitle')
                            ->label('Section Subtitle')
                            ->default('Calendar')
                            ->maxLength(255)
                            ->columnSpan(1),

                        FormComponents\Textarea::make('description')
                            ->label('Section Description')
                            ->default('Stay aligned with admission briefings, community gatherings, and student showcases inspired by Duha\'s rhythm.')
                            ->maxLength(500)
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Components\Section::make('Events Settings')
                    ->description('Configure how events are displayed')
                    ->schema([
                        FormComponents\TextInput::make('data.events_title')
                            ->label('Events Column Title')
                            ->default('Upcoming Events')
                            ->maxLength(255),

                        FormComponents\TextInput::make('data.events_count')
                            ->label('Number of Events to Show')
                            ->numeric()
                            ->default(3)
                            ->minValue(1)
                            ->maxValue(10)
                            ->helperText('How many upcoming events to display'),

                        FormComponents\Toggle::make('data.show_events')
                            ->label('Show Events Column')
                            ->default(true)
                            ->helperText('Toggle to show/hide the events column'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Components\Section::make('Notices Settings')
                    ->description('Configure how notices are displayed')
                    ->schema([
                        FormComponents\TextInput::make('data.notices_title')
                            ->label('Notices Column Title')
                            ->default('Important Notices')
                            ->maxLength(255),

                        FormComponents\TextInput::make('data.notices_count')
                            ->label('Number of Notices to Show')
                            ->numeric()
                            ->default(3)
                            ->minValue(1)
                            ->maxValue(10)
                            ->helperText('How many important notices to display'),

                        FormComponents\Toggle::make('data.show_notices')
                            ->label('Show Notices Column')
                            ->default(true)
                            ->helperText('Toggle to show/hide the notices column'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Components\Section::make('Call-to-Action')
                    ->description('Configure the calendar download button')
                    ->schema([
                        FormComponents\TextInput::make('data.cta_text')
                            ->label('CTA Button Text')
                            ->default('Download Academic Calendar')
                            ->maxLength(255),

                        FormComponents\TextInput::make('data.cta_link')
                            ->label('CTA Button Link')
                            ->url()
                            ->default('#calendar')
                            ->maxLength(500)
                            ->helperText('Link to calendar PDF or page'),

                        FormComponents\Toggle::make('data.show_cta')
                            ->label('Show CTA Button')
                            ->default(true),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Components\Section::make('View All Links')
                    ->description('Configure the "View All" buttons at the bottom')
                    ->schema([
                        FormComponents\Toggle::make('data.show_view_all_events')
                            ->label('Show "View All Events" Button')
                            ->default(true),

                        FormComponents\Toggle::make('data.show_view_all_notices')
                            ->label('Show "View All Notices" Button')
                            ->default(true),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Components\Section::make('Display Settings')
                    ->schema([
                        FormComponents\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(4)
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
