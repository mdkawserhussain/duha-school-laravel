<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn () => route('events.show', $this->record))
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->is_published ?? false),
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}