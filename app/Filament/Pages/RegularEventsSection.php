<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\ManagesHomePageSection;
use BackedEnum;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use UnitEnum;

class RegularEventsSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationLabel = 'Regular Events';

    protected static ?string $title = 'Regular Events Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 4;

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Hidden - Events are fetched dynamically via EventService
    }

    protected string $view = 'filament.pages.regular-events-section';

    protected function getSectionKey(): string
    {
        return 'info_events';
    }

    protected function getSectionType(): string
    {
        return 'info_block';
    }

    protected function getSectionTitle(): string
    {
        return 'Regular Events Section';
    }
}

