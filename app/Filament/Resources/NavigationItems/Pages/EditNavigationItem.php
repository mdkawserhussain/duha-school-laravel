<?php

namespace App\Filament\Resources\NavigationItems\Pages;

use App\Filament\Resources\NavigationItems\NavigationItemResource;
use App\Services\NavigationService;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\App;

class EditNavigationItem extends EditRecord
{
    protected static string $resource = NavigationItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->after(function () {
                    $navigationService = App::make(NavigationService::class);
                    $navigationService->clearNavigationCache();
                }),
            ForceDeleteAction::make()
                ->after(function () {
                    $navigationService = App::make(NavigationService::class);
                    $navigationService->clearNavigationCache();
                }),
            RestoreAction::make()
                ->after(function () {
                    $navigationService = App::make(NavigationService::class);
                    $navigationService->clearNavigationCache();
                }),
        ];
    }

    protected function afterSave(): void
    {
        $navigationService = App::make(NavigationService::class);
        $navigationService->clearNavigationCache();

        Notification::make()
            ->title('Navigation item updated successfully')
            ->success()
            ->send();
    }
}
