<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UpcomingEvents extends BaseWidget
{
    protected static ?string $heading = 'Upcoming Events';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $orderClause = \Illuminate\Support\Facades\Schema::hasColumn('events', 'start_at') ? 'COALESCE(start_at, event_date)' : 'event_date';

        return $table
            ->query(
                Event::published()
                    ->upcoming()
                    ->orderByRaw($orderClause . ' asc')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->circular()
                    ->defaultImageUrl('/images/placeholder.svg')
                    ->size(40),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Academic' => 'success',
                        'Social' => 'info',
                        'Islamic' => 'warning',
                        'Sports' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('start_at')
                    ->label('Date & Time')
                    ->formatStateUsing(function ($state, $record) {
                        $start = $record->start_at ?? $record->event_date ?? null;

                        if (!$start) {
                            return null;
                        }

                        return $start->format('M j, Y \a\t g:i A');
                    }),

                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->limit(20),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
            ])
            ->actions([
                Action::make('view')
                    ->url(fn (Event $record): string => route('filament.admin.resources.events.view', $record))
                    ->icon('heroicon-m-eye'),

                Action::make('edit')
                    ->url(fn (Event $record): string => route('filament.admin.resources.events.edit', $record))
                    ->icon('heroicon-m-pencil-square'),
            ])
            ->emptyStateHeading('No upcoming events')
            ->emptyStateDescription('Create your first event to get started.')
            ->emptyStateIcon('heroicon-o-calendar-days');
    }
}