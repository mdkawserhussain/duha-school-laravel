<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NoticeResource\Pages;
use App\Models\Notice;
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

class NoticeResource extends Resource
{
    protected static ?string $model = Notice::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bell-alert';

    protected static string|UnitEnum|null $navigationGroup = 'Notices';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Notice Information')
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
                                        $slug = 'notice-' . time();
                                    }
                                    $set('slug', $slug);
                                }
                            }),

                        FormComponents\Textarea::make('excerpt')
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
                                            $slug = 'notice-' . time();
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
                                    return 'notice-' . time();
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
                            ->helperText('Brief summary of the notice (shown in listings)')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull(),

                        FormComponents\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull(),

                        FormComponents\FileUpload::make('featured_image')
                            ->image()
                            ->directory('notices')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ]),
                    ])
                    ->columns(2),

                Components\Section::make('Notice Settings')
                    ->schema([
                        FormComponents\TextInput::make('category')
                            ->maxLength(100)
                            ->placeholder('e.g., Academic, Administrative, Events, General'),

                        FormComponents\Toggle::make('is_important')
                            ->label('Important Notice')
                            ->helperText('Important notices appear prominently and get special styling')
                            ->default(false),

                        FormComponents\DateTimePicker::make('published_at')
                            ->label('Publish At')
                            ->default(now())
                            ->required(),
                    ])
                    ->columns(2),

                Components\Section::make('Publishing')
                    ->schema([
                        FormComponents\Toggle::make('is_published')
                            ->label('Published')
                            ->helperText('Only published notices will be visible on the website')
                            ->default(true)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Featured Image')
                    ->circular()
                    ->defaultImageUrl('/images/placeholder.svg')
                    ->state(function ($record) {
                        if (!$record || !$record->exists) {
                            return null;
                        }
                        return $record->hasMedia('featured_image') 
                            ? $record->getFirstMediaUrl('featured_image', 'thumb') 
                            : null;
                    }),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Academic' => 'success',
                        'Administrative' => 'info',
                        'Events' => 'warning',
                        'General' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_important')
                    ->boolean()
                    ->label('Important')
                    ->trueIcon('heroicon-o-exclamation-triangle')
                    ->falseIcon('heroicon-o-minus'),

                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Published'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published')
                    ->placeholder('All')
                    ->trueLabel('Published only')
                    ->falseLabel('Draft only'),

                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Academic' => 'Academic',
                        'Administrative' => 'Administrative',
                        'Events' => 'Events',
                        'General' => 'General',
                    ]),

                Tables\Filters\TernaryFilter::make('is_important')
                    ->label('Important Notices')
                    ->placeholder('All')
                    ->trueLabel('Important only')
                    ->falseLabel('Regular only'),
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
            ->defaultSort('published_at', 'desc');
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
            'index' => Pages\ListNotices::route('/'),
            'create' => Pages\CreateNotice::route('/create'),
            'view' => Pages\ViewNotice::route('/{record:id}'),
            'edit' => Pages\EditNotice::route('/{record:id}/edit'),
        ];
    }

    public static function resolveRecordRouteBinding(string|int $key, ?\Closure $modifyQuery = null): ?Notice
    {
        // For admin routes, always resolve by ID, not slug
        $query = static::getEloquentQuery()->where(static::getModel()::make()->getKeyName(), $key);
        
        if ($modifyQuery) {
            $modifyQuery($query);
        }
        
        return $query->first();
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

    public static function canView($record): bool
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