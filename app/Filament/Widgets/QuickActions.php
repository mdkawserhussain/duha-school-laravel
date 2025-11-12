<?php

namespace App\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Widgets\Widget;

class QuickActions extends Widget implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    protected string $view = 'filament.widgets.quick-actions';

    protected int | string | array $columnSpan = 'full';

    protected function getActions(): array
    {
        return [
            Action::make('create_page')
                ->label('Create New Page')
                ->icon('heroicon-o-document-duplicate')
                ->color('success')
                ->url(route('filament.admin.resources.pages.create')),

            Action::make('create_event')
                ->label('Add Event')
                ->icon('heroicon-o-calendar')
                ->color('info')
                ->url(route('filament.admin.resources.events.create')),

            Action::make('create_notice')
                ->label('Post Notice')
                ->icon('heroicon-o-bell')
                ->color('warning')
                ->url(route('filament.admin.resources.notices.create')),

            Action::make('add_staff')
                ->label('Add Staff Member')
                ->icon('heroicon-o-user')
                ->color('primary')
                ->url(route('filament.admin.resources.staff.create')),

            Action::make('view_applications')
                ->label('Review Applications')
                ->icon('heroicon-o-document-text')
                ->color('danger')
                ->badge(fn (): ?string => \App\Models\AdmissionApplication::where('status', 'pending')->count() ?: null)
                ->url(route('filament.admin.resources.admission-applications.index')),

            Action::make('view_career_apps')
                ->label('Career Applications')
                ->icon('heroicon-o-briefcase')
                ->color('gray')
                ->badge(fn (): ?string => \App\Models\CareerApplication::where('status', 'pending')->count() ?: null)
                ->url(route('filament.admin.resources.career-applications.index')),
        ];
    }

    public function getQuickActions(): array
    {
        return $this->getActions();
    }
}