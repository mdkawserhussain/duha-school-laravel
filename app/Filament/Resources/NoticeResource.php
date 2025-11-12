<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NoticeResource\Pages;
use App\Models\Notice;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;
use UnitEnum;

class NoticeResource extends Resource
{
    protected static ?string $model = Notice::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bell-alert';

    protected static string|UnitEnum|null $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Notice Information')
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

                        Components\FileUpload::make('featured_image')
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
                        Components\TextInput::make('category')
                            ->maxLength(100)
                            ->placeholder('e.g., Academic, Administrative, Events, General'),

                        Components\Toggle::make('is_featured')
                            ->label('Important Notice')
                            ->helperText('Important notices appear prominently and get special styling'),

                        Components\DateTimePicker::make('published_at')
                            ->label('Publish At')
                            ->default(now())
                            ->required(),
                    ])
                    ->columns(2),

                Components\Section::make('Publishing')
                    ->schema([
                        Components\Select::make('status')
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
                    ->defaultImageUrl('/images/placeholder.png'),

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