<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\ManagesHomePageSection;
use BackedEnum;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use UnitEnum;

class EnrollmentNewsSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-plus-circle';

    protected static ?string $navigationLabel = 'Enrollment News';

    protected static ?string $title = 'Enrollment News Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.enrollment-news-section';

    protected function getSectionKey(): string
    {
        return 'info_enrollment';
    }

    protected function getSectionType(): string
    {
        return 'info_block';
    }

    protected function getSectionTitle(): string
    {
        return 'Enrollment News Section';
    }
}

