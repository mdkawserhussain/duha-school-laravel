<?php

namespace App\Filament\Widgets;

use App\Models\AdmissionApplication;
use App\Models\CareerApplication;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentApplications_disabled extends BaseWidget
{
    protected static ?string $heading = 'Recent Applications';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                AdmissionApplication::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('child_name')
                    ->label('Applicant')
                    ->searchable(),

                Tables\Columns\TextColumn::make('grade_applied')
                    ->label('Grade')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'reviewed' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Applied')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('parent_name')
                    ->label('Parent')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Action::make('view')
                    ->url(fn (AdmissionApplication $record): string => route('filament.admin.resources.admission-applications.view', $record))
                    ->icon('heroicon-m-eye'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}