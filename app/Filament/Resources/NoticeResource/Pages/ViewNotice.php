<?php

namespace App\Filament\Resources\NoticeResource\Pages;

use App\Filament\Resources\NoticeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewNotice extends ViewRecord
{
    protected static string $resource = NoticeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Preview on Site')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn () => route('notices.show', $this->record))
                ->openUrlInNewTab()
                ->visible(fn () => $this->record && ($this->record->is_published ?? false)),
            Actions\EditAction::make(),
        ];
    }
}