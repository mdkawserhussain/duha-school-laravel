<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;
use UnitEnum;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static string|UnitEnum|null $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Event Information')
                    ->schema([
                        Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $state, Components\Set $set) {
                                $set('slug', str($state)->slug());
                            }),

                        Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->rules(['alpha_dash']),

                        Components\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull(),

                        Components\TextInput::make('location')
                            ->maxLength(255),

                        Components\FileUpload::make('featured_image')
                            ->image()
                            ->directory('events')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ]),
                    ])
                    ->columns(2),

                Components\Section::make('Event Schedule')
                    ->schema([
                        Components\DateTimePicker::make('start_at')
                            ->required()
                            ->label('Start Date & Time'),

                        Components\DateTimePicker::make('end_at')
                            ->label('End Date & Time')
                            ->after('start_at'),

                        Components\TextInput::make('category')
                            ->maxLength(100)
                            ->placeholder('e.g., Academic, Social, Islamic, Sports'),

                        Components\Toggle::make('is_featured')
                            ->label('Featured Event')
                            ->helperText('Featured events appear prominently on the homepage'),
                    ])
                    ->columns(2),

                Components\Section::make('Publishing')
                    ->schema([
                        Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->default('draft')
                            ->required(),

                        Components\DateTimePicker::make('published_at')
                            ->label('Publish At')
                            ->default(now())
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->circular()
                    ->defaultImageUrl('/images/placeholder.png'),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

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
                    ->dateTime()
                    ->sortable()
                    ->label('Start Date'),

                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'secondary',
                        'published' => 'success',
                        'archived' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),

                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Academic' => 'Academic',
                        'Social' => 'Social',
                        'Islamic' => 'Islamic',
                        'Sports' => 'Sports',
                    ]),

                Tables\Filters\Filter::make('is_featured')
                    ->label('Featured Events')
                    ->query(fn (Builder $query): Builder => $query->where('is_featured', true)),

                Tables\Filters\Filter::make('upcoming')
                    ->label('Upcoming Events')
                    ->query(fn (Builder $query): Builder => $query->where('start_at', '>', now())),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('start_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'view' => Pages\ViewEvent::route('/{record}'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasAnyRole(['admin', 'editor']) ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->hasAnyRole(['admin', 'editor']) ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->hasAnyRole(['admin', 'editor']) ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }
}