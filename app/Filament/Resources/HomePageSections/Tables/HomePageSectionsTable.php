<?php

namespace App\Filament\Resources\HomePageSections\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HomePageSectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('section_key')
                    ->label('Section Key')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('section_type')
                    ->label('Type')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'hero' => 'primary',
                        'info_block' => 'info',
                        'info_blocks' => 'info',
                        'events' => 'success',
                        'content' => 'success',
                        'video' => 'warning',
                        'videos' => 'warning',
                        'list' => 'warning',
                        'advisors' => 'danger',
                        'board' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->title),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->alignCenter(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->defaultSort('sort_order')
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->after(function () {
                            // Clear homepage cache so deleted sliders are removed immediately
                            cache()->forget('homepage_data');
                        }),
                ]),
            ]);
    }
}
