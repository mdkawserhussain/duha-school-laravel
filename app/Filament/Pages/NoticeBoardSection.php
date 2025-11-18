<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\ManagesHomePageSection;
use BackedEnum;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use UnitEnum;

class NoticeBoardSection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationLabel = 'Notice Board';

    protected static ?string $title = 'Notice Board Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 5;

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Hidden - Not used in homepage template
    }

    protected string $view = 'filament.pages.notice-board-section';

    protected function getSectionKey(): string
    {
        return 'info_notice';
    }

    protected function getSectionType(): string
    {
        return 'info_block';
    }

    protected function getSectionTitle(): string
    {
        return 'Notice Board Section';
    }
}

