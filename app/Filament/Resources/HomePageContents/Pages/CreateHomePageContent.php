<?php

namespace App\Filament\Resources\HomePageContents\Pages;

use App\Filament\Resources\HomePageContents\HomePageContentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cache;

class CreateHomePageContent extends CreateRecord
{
    protected static string $resource = HomePageContentResource::class;

    protected function afterCreate(): void
    {
        // Clear homepage cache after creation
        Cache::forget('homepage_v2_data');
    }
}
