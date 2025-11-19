<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Forms\Components as FormComponents;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use BackedEnum;
use UnitEnum;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static string|UnitEnum|null $navigationGroup = 'Events';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Event Information')
                    ->schema([
                        FormComponents\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $state, $set, $get) {
                                if (!empty(trim($state))) {
                                    $slug = str(trim($state))->slug()->lower()->toString();
                                    // Ensure slug is not empty (handle edge case of only special characters)
                                    if (empty($slug)) {
                                        $slug = 'event-' . time();
                                    }
                                    $set('slug', $slug);
                                }
                            }),

                        FormComponents\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, $set, $get) {
                                if (!empty($state)) {
                                    // Handle both string and Stringable objects
                                    $slugValue = is_string($state) ? $state : (string) $state;
                                    $slug = str(trim($slugValue))->slug()->lower()->toString();
                                    // Ensure slug is not empty
                                    if (empty($slug)) {
                                        // Fallback: use title if available, otherwise generate timestamp-based slug
                                        $title = $get('title');
                                        if (!empty($title)) {
                                            $slug = str(trim($title))->slug()->lower()->toString();
                                        }
                                        if (empty($slug)) {
                                            $slug = 'event-' . time();
                                        }
                                    }
                                    $set('slug', $slug);
                                }
                            })
                            ->dehydrateStateUsing(function ($state) {
                                // Always ensure we return a valid string slug
                                if (empty($state)) {
                                    return '';
                                }
                                
                                // Convert Stringable to string if needed
                                if (!is_string($state)) {
                                    $state = (string) $state;
                                }
                                
                                // Normalize the slug
                                $slug = str(trim($state))->slug()->lower()->toString();
                                
                                // Ensure slug is not empty
                                if (empty($slug)) {
                                    return 'event-' . time();
                                }
                                
                                return $slug;
                            })
                            ->rules([
                                'required',
                                'string',
                                'max:255',
                                'regex:/^[a-z0-9_-]+$/',
                            ])
                            ->helperText('Only lowercase letters, numbers, dashes, and underscores are allowed'),

                        FormComponents\Textarea::make('excerpt')
                            ->label('Excerpt')
                            ->helperText('Brief summary of the event (shown in listings)')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull(),

                        FormComponents\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull(),

                        FormComponents\TextInput::make('location')
                            ->maxLength(255),

                        FormComponents\FileUpload::make('featured_image')
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
                        FormComponents\DateTimePicker::make('start_at')
                            ->required()
                            ->label('Start Date & Time'),

                        FormComponents\DateTimePicker::make('end_at')
                            ->label('End Date & Time')
                            ->after('start_at'),

                        FormComponents\TextInput::make('category')
                            ->maxLength(100)
                            ->placeholder('e.g., Academic, Social, Islamic, Sports'),

                        FormComponents\Toggle::make('is_featured')
                            ->label('Featured Event')
                            ->helperText('Featured events appear prominently on the homepage'),
                    ])
                    ->columns(2),

                Components\Section::make('Publishing')
                    ->schema([
                        FormComponents\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->default('draft')
                            ->required(),

                        FormComponents\DateTimePicker::make('published_at')
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
                    ->defaultImageUrl('/images/placeholder.svg'),

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
                    ->label('Start Date')
                    ->formatStateUsing(function ($state, $record) {
                        $start = $record->start_at ?? $record->event_date ?? null;

                        return $start ? $start->format('M j, Y \a\t g:i A') : null;
                    })
                    ->sortable(\Illuminate\Support\Facades\Schema::hasColumn('events', 'start_at') ? 'start_at' : 'event_date'),

                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),

                // If the `status` column exists we show status, else fall back to showing published boolean
                \Illuminate\Support\Facades\Schema::hasColumn('events', 'status')
                    ? Tables\Columns\TextColumn::make('status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'draft' => 'secondary',
                            'published' => 'success',
                            'archived' => 'gray',
                            default => 'gray',
                        })
                    : Tables\Columns\IconColumn::make('is_published')
                        ->boolean()
                        ->label('Published'),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Show either a status filter if the column exists,
                // else provide a virtual filter that maps to is_published/published_at
                (\Illuminate\Support\Facades\Schema::hasColumn('events', 'status')
                    ? Tables\Filters\SelectFilter::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                            'archived' => 'Archived',
                        ])
                    : Tables\Filters\Filter::make('status')
                        ->form([
                            FormComponents\Select::make('status')
                                ->options([
                                    'draft' => 'Draft',
                                    'published' => 'Published',
                                    'archived' => 'Archived',
                                ]),
                        ])
                        ->query(function (Builder $query, array $data): Builder {
                            $status = $data['status'] ?? null;
                            if (!$status) {
                                return $query;
                            }

                            if ($status === 'published') {
                                return $query->where('is_published', true)->where('published_at', '<=', now());
                            }

                            // For draft or archived, filter by not published
                            return $query->where(function (Builder $q) use ($status) {
                                if ($status === 'draft') {
                                    $q->where('is_published', false)->orWhereNull('published_at');
                                } else {
                                    $q->where('is_published', false);
                                }
                            });
                        })
                ),

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
                    ->query(fn (Builder $query): Builder => (
                        \Illuminate\Support\Facades\Schema::hasColumn('events', 'start_at')
                            ? $query->where('start_at', '>', now())
                            : $query->where('event_date', '>', now())
                    )),
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
            ->defaultSort(\Illuminate\Support\Facades\Schema::hasColumn('events', 'start_at') ? 'start_at' : 'event_date', 'desc');
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

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function canViewAny(): bool
    {
        return static::currentUser()?->hasAnyRole(['admin', 'editor']) ?? false;
    }

    public static function canCreate(): bool
    {
        return static::currentUser()?->hasAnyRole(['admin', 'editor']) ?? false;
    }

    public static function canEdit($record): bool
    {
        return static::currentUser()?->hasAnyRole(['admin', 'editor']) ?? false;
    }

    public static function canDelete($record): bool
    {
        return static::currentUser()?->hasRole('admin') ?? false;
    }

    protected static function currentUser(): ?User
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user;
    }
}
