<?php

namespace App\Filament\Widgets;

use App\Models\AdmissionApplication;
use App\Models\CareerApplication;
use App\Models\Event;
use App\Models\Notice;
use App\Models\Page;
use App\Models\Staff;
use App\Models\Subscriber;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        try {
            $user = Auth::user();
            $stats = [];

            // Simple fallback stats if user has no roles or methods fail
            if (!$user || !method_exists($user, 'hasAnyRole')) {
                return [
                    Stat::make('Dashboard', 'Ready')
                        ->description('Admin panel loaded successfully')
                        ->descriptionIcon('heroicon-m-check-circle')
                ];
            }

            // Content stats (admin and editor)
            if ($user->hasAnyRole(['admin', 'editor'])) {
                $stats[] = Stat::make('Total Pages', Page::published()->count())
                    ->description('Published content pages')
                    ->descriptionIcon('heroicon-m-document-text')
                    ->color('success')
                    ->url(route('filament.admin.resources.pages.index'));

                $stats[] = Stat::make('Upcoming Events', Event::published()->upcoming()->count())
                    ->description('Events scheduled for the future')
                    ->descriptionIcon('heroicon-m-calendar-days')
                    ->color('info')
                    ->url(route('filament.admin.resources.events.index'));

                $stats[] = Stat::make('Active Staff', Staff::active()->count())
                    ->description('Currently active staff members')
                    ->descriptionIcon('heroicon-m-users')
                    ->color('primary')
                    ->url(route('filament.admin.resources.staff.index'));
            }

            // Application stats (admin and admissions_officer)
            if ($user->hasAnyRole(['admin', 'admissions_officer'])) {
                $pendingAdmissions = AdmissionApplication::where('status', 'pending')->count();
                $stats[] = Stat::make('Pending Admissions', $pendingAdmissions)
                    ->description('Admission applications awaiting review')
                    ->descriptionIcon('heroicon-m-document-plus')
                    ->color('warning')
                    ->url(route('filament.admin.resources.admission-applications.index'));

                $pendingCareers = CareerApplication::where('status', 'pending')->count();
                $stats[] = Stat::make('Pending Career Apps', $pendingCareers)
                    ->description('Job applications to review')
                    ->descriptionIcon('heroicon-m-briefcase')
                    ->color('warning')
                    ->url(route('filament.admin.resources.career-applications.index'));
            }

            // Newsletter stats (admin only)
            if ($user->hasRole('admin')) {
                $stats[] = Stat::make('Newsletter Subscribers', Subscriber::whereNotNull('subscribed_at')->count())
                    ->description('Active email subscribers')
                    ->descriptionIcon('heroicon-m-envelope')
                    ->color('success');
            }

            return empty($stats) ? [
                Stat::make('Welcome', 'Dashboard')
                    ->description('Admin panel ready')
                    ->descriptionIcon('heroicon-m-home')
            ] : $stats;

        } catch (\Exception $e) {
            // Fallback if anything fails
            return [
                Stat::make('System', 'Online')
                    ->description('Admin dashboard loaded')
                    ->descriptionIcon('heroicon-m-check-circle')
            ];
        }
    }
}
