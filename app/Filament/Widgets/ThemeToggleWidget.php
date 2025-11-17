<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ThemeToggleWidget extends Widget
{
    // `Widget::$view` in Filament is an instance property, not static. Keep the same signature.
    protected string $view = 'filament.widgets.theme-toggle';

    // Filament `Widget::$sort` expects an `?int` type. Use an integer or null here.
    protected static ?int $sort = 0;

    protected static string $title = 'Theme';
}
