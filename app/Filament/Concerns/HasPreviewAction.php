<?php

namespace App\Filament\Concerns;

use Filament\Actions\Action;

trait HasPreviewAction
{
    protected function getPreviewAction(): Action
    {
        return Action::make('preview')
            ->label('Preview')
            ->icon('heroicon-o-eye')
            ->color('gray')
            ->url(fn () => $this->getPreviewUrl())
            ->openUrlInNewTab()
            ->visible(fn () => $this->record?->is_published ?? false);
    }

    abstract protected function getPreviewUrl(): string;
}

