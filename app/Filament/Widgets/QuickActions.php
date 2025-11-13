<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class QuickActions extends Widget
{
    protected string $view = 'filament.widgets.quick-actions-simple';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function getQuickLinks(): array
    {
        return [
            [
                'label' => 'Create Page',
                'url' => '/admin/pages/create',
                'icon' => 'heroicon-o-document-text',
                'color' => 'green',
            ],
            [
                'label' => 'Add Event',
                'url' => '/admin/events/create',
                'icon' => 'heroicon-o-calendar-days',
                'color' => 'blue',
            ],
            [
                'label' => 'Post Notice',
                'url' => '/admin/notices/create',
                'icon' => 'heroicon-o-bell',
                'color' => 'orange',
            ],
            [
                'label' => 'Add Staff',
                'url' => '/admin/staff/create',
                'icon' => 'heroicon-o-user',
                'color' => 'purple',
            ],
            [
                'label' => 'Applications',
                'url' => '/admin/admission-applications',
                'icon' => 'heroicon-o-document-text',
                'color' => 'red',
            ],
            [
                'label' => 'Career Apps',
                'url' => '/admin/career-applications',
                'icon' => 'heroicon-o-briefcase',
                'color' => 'gray',
            ],
        ];
    }
}
