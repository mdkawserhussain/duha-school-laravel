<?php

namespace App\Filament\Resources\Announcements\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn as TableTextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AnnouncementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TableTextColumn::make('message')
                    ->label('Message')
                    ->searchable()
                    ->limit(60)
                    ->tooltip(function (TableTextColumn $column): ?string {
                        try {
                            \Log::debug('AnnouncementsTable::message tooltip', [
                                'column_state' => $column->getState(),
                                'state_type' => gettype($column->getState()),
                            ]);
                            
                            $state = $column->getState();
                            if (empty($state) || strlen($state) <= 60) {
                                return null;
                            }
                            
                            // Sanitize for tooltip
                            if (!mb_check_encoding($state, 'UTF-8')) {
                                \Log::warning('AnnouncementsTable::message tooltip invalid UTF-8', [
                                    'state_hex' => bin2hex(substr($state, 0, 100)),
                                ]);
                                $state = mb_convert_encoding($state, 'UTF-8', 'UTF-8');
                            }
                            
                            return $state;
                        } catch (\Throwable $e) {
                            \Log::error('AnnouncementsTable::message tooltip ERROR', [
                                'error' => $e->getMessage(),
                                'trace' => $e->getTraceAsString(),
                            ]);
                            return null;
                        }
                    })
                    ->formatStateUsing(function ($state) {
                        try {
                            \Log::debug('AnnouncementsTable::message formatStateUsing', [
                                'state_type' => gettype($state),
                                'state_length' => is_string($state) ? strlen($state) : null,
                            ]);
                            
                            if (empty($state)) {
                                return $state;
                            }
                            
                            // Ensure valid UTF-8
                            if (!mb_check_encoding($state, 'UTF-8')) {
                                \Log::warning('AnnouncementsTable::message formatStateUsing invalid UTF-8');
                                $state = mb_convert_encoding($state, 'UTF-8', 'UTF-8');
                            }
                            
                            return $state;
                        } catch (\Throwable $e) {
                            \Log::error('AnnouncementsTable::message formatStateUsing ERROR', [
                                'error' => $e->getMessage(),
                                'trace' => $e->getTraceAsString(),
                            ]);
                            return '';
                        }
                    })
                    ->wrap(),
                
                TableTextColumn::make('link')
                    ->label('Link')
                    ->url(fn ($record) => $record->link)
                    ->openUrlInNewTab()
                    ->limit(30)
                    ->default('-')
                    ->icon('heroicon-o-link'),
                
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                TableTextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->alignCenter(),
                
                TableTextColumn::make('starts_at')
                    ->label('Starts')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ? $state->format('M d, Y H:i') : '-'),
                
                TableTextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ? $state->format('M d, Y H:i') : '-')
                    ->color(fn ($record) => $record->expires_at && $record->expires_at->isPast() ? 'danger' : null),
                
                TableTextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('is_active')
                    ->label('Active Only')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
                
                Filter::make('expired')
                    ->label('Expired')
                    ->query(fn (Builder $query): Builder => $query->where('expires_at', '<', now())),
                
                Filter::make('upcoming')
                    ->label('Upcoming')
                    ->query(fn (Builder $query): Builder => $query->where('starts_at', '>', now())),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
