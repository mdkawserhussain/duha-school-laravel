<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\ManagesHomePageSection;
use BackedEnum;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use UnitEnum;

class UpcomingEventsSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Upcoming Events';

    protected static ?string $title = 'Upcoming Events Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 4;

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Hidden - Events are fetched dynamically via EventService
    }

    protected string $view = 'filament.pages.upcoming-events-section';

    protected function getSectionKey(): string
    {
        return 'upcoming_events';
    }

    protected function getSectionType(): string
    {
        return 'events';
    }

    protected function getSectionTitle(): string
    {
        return 'Upcoming Events Section';
    }
}
