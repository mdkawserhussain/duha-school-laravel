<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\ManagesHomePageSection;
use BackedEnum;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use UnitEnum;

class CallToActionSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-right-circle';

    protected static ?string $navigationLabel = 'Call to Action';

    protected static ?string $title = 'Call to Action Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 12;

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Hidden - Not used in homepage template
    }

    protected string $view = 'filament.pages.call-to-action-section';

    protected function getSectionKey(): string
    {
        return 'cta_banner';
    }

    protected function getSectionType(): string
    {
        return 'content';
    }

    protected function getSectionTitle(): string
    {
        return 'Call to Action Section';
    }
}

