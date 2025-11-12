<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingsResource;
use App\Models\SiteSettings;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\IconPosition;

class ListSiteSettings extends ListRecords
{
    protected static string $resource = SiteSettingsResource::class;

    public function getTitle(): string
    {
        return 'Site Settings';
    }

    protected function getHeaderActions(): array
    {
        $settings = SiteSettings::first();
        if ($settings) {
            return [
                Action::make('edit')
                    ->label('Edit Settings')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->iconPosition(IconPosition::Before)
                    ->color('primary')
                    ->url(static::getResource()::getUrl('edit', ['record' => $settings])),
            ];
        }
        return [
            Action::make('create')
                ->label('Create Settings')
                ->icon('heroicon-o-plus')
                ->iconPosition(IconPosition::Before)
                ->color('success')
                ->url(static::getResource()::getUrl('create')),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }
}
