<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\ManagesHomePageSection;
use BackedEnum;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use UnitEnum;

class CTABannerSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationLabel = 'CTA Banner';

    protected static ?string $title = 'Call-to-Action Banner Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 5;

    protected string $view = 'filament.pages.c-t-a-banner-section';

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
        return 'Call-to-Action Banner Section';
    }
}
