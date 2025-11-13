<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn () => route('pages.show', $this->record->slug))
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->is_published ?? false),
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}