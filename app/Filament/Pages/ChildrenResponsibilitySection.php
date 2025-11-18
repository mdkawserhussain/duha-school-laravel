<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\ManagesHomePageSection;
use BackedEnum;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use UnitEnum;

class ChildrenResponsibilitySection extends Page implements HasForms
{
    use ManagesHomePageSection;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationLabel = 'Children Responsibility';

    protected static ?string $title = 'Children Responsibility Section';

    protected static string|UnitEnum|null $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 8;

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Hidden - Not used in homepage template
    }

    protected string $view = 'filament.pages.children-responsibility-section';

    protected function getSectionKey(): string
    {
        return 'children_responsibility';
    }

    protected function getSectionType(): string
    {
        return 'content';
    }

    protected function getSectionTitle(): string
    {
        return 'Your Children, Our Responsibility Section';
    }
}

