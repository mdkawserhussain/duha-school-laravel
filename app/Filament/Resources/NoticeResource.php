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
                            ->afterStateUpdated(function (string $state, $set) {
                                if (!empty($state)) {
                                    $set('slug', str($state)->slug()->lower());
                                }
                            }),

                        FormComponents\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, $set) {
                                if (!empty($state) && is_string($state)) {
                                    $slug = str(trim($state))->slug()->lower()->toString();
                                    $set('slug', $slug);
                                }
                            })
                            ->dehydrateStateUsing(function ($state) {
                                if (empty($state)) {
                                    return '';
                                }
                                if (!is_string($state)) {
                                    return (string) $state;
                                }
                                return str(trim($state))->slug()->lower()->toString();
                            })
                            ->rules([
                                'required',
                                'string',
                                'max:255',
                                'regex:/^[a-z0-9_-]+$/',
                            ])
                            ->helperText('Only lowercase letters, numbers, dashes, and underscores are allowed'),

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

                        FormComponents\Toggle::make('is_featured')
                            ->label('Important Notice')
                            ->helperText('Important notices appear prominently and get special styling'),

                        FormComponents\DateTimePicker::make('published_at')
                            ->label('Publish At')
                            ->default(now())
                            ->required(),
                    ])
                    ->columns(2),

                Components\Section::make('Publishing')
                    ->schema([
                        FormComponents\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->default('published')
                            ->required(),
                    ]),
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

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Important')
                    ->trueIcon('heroicon-o-exclamation-triangle')
                    ->falseIcon('heroicon-o-minus'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'secondary',
                        'published' => 'success',
                        default => 'gray',
                    }),

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
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ]),

                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Academic' => 'Academic',
                        'Administrative' => 'Administrative',
                        'Events' => 'Events',
                        'General' => 'General',
                    ]),

                Tables\Filters\Filter::make('is_featured')
                    ->label('Important Notices')
                    ->query(fn (Builder $query): Builder => $query->where('is_featured', true)),
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
            'view' => Pages\ViewNotice::route('/{record}'),
            'edit' => Pages\EditNotice::route('/{record}/edit'),
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