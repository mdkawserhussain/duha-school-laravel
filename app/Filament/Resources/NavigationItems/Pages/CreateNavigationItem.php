<?php

namespace App\Filament\Resources\NavigationItems\Pages;

use App\Filament\Resources\NavigationItems\NavigationItemResource;
use App\Services\NavigationService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\App;

class CreateNavigationItem extends CreateRecord
{
    protected static string $resource = NavigationItemResource::class;

    protected function afterCreate(): void
    {
        $navigationService = App::make(NavigationService::class);
        $navigationService->clearNavigationCache();

        Notification::make()
            ->title('Navigation item created successfully')
            ->success()
            ->send();
    }
}
