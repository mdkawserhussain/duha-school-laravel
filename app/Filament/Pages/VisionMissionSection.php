<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\ManagesHomePageSection;
use BackedEnum;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use UnitEnum;

class VisionMissionSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-eye';

    protected static ?string $navigationLabel = 'Vision & Mission';

    protected static ?string $title = 'Vision & Mission Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.vision-mission-section';

    protected function getSectionKey(): string
    {
        return 'vision';
    }

    protected function getSectionType(): string
    {
        return 'content';
    }

    protected function getSectionTitle(): string
    {
        return 'Vision & Mission Section';
    }
}
