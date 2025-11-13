<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\ManagesHomePageSection;
use BackedEnum;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use UnitEnum;

class WhyChooseUsSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Why Choose Us';

    protected static ?string $title = 'Why Choose Us Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.why-choose-us-section';

    protected function getSectionKey(): string
    {
        return 'why_choose';
    }

    protected function getSectionType(): string
    {
        return 'content';
    }

    protected function getSectionTitle(): string
    {
        return 'Why Choose Al-Maghrib Section';
    }
}
