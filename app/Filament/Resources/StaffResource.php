<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaffResource\Pages;
use App\Models\Staff;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;
use UnitEnum;

class StaffResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string|UnitEnum|null $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Staff Information')
                    ->schema([
                        Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Components\TextInput::make('role_title')
                            ->required()
                            ->maxLength(255)
                            ->label('Role/Title'),

                        Components\Textarea::make('bio')
                            ->maxLength(1000)
                            ->rows(4)
                            ->columnSpanFull(),

                        Components\FileUpload::make('photo')
                            ->image()
                            ->directory('staff')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '3:4',
                            ])
                            ->helperText('Upload a professional headshot (square or portrait orientation recommended)'),
                    ])
                    ->columns(2),

                Components\Section::make('Contact Information')
                    ->schema([
                        Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),

                        Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(20),

                        Components\Repeater::make('social_links')
                            ->schema([
                                Components\Select::make('platform')
                                    ->options([
                                        'facebook' => 'Facebook',
                                        'twitter' => 'Twitter',
                                        'linkedin' => 'LinkedIn',
                                        'instagram' => 'Instagram',
                                    ])
                                    ->required(),
                                Components\TextInput::make('url')
                                    ->url()
                                    ->required()
                                    ->label('Profile URL'),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->helperText('Add social media profiles for this staff member'),
                    ])
                    ->columns(2),

                Components\Section::make('Display Settings')
                    ->schema([
                        Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first. Use this to control display order.'),

                        Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Inactive staff members won\'t appear on the public website'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->circular()
                    ->defaultImageUrl('/images/placeholder.png')
                    ->size(40),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('role_title')
                    ->searchable()
                    ->label('Role'),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),

                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->label('Active Staff')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),

                Tables\Filters\Filter::make('has_social_links')
                    ->label('Has Social Media')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('social_links')),
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
            ->defaultSort('order', 'asc');
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
            'index' => Pages\ListStaff::route('/'),
            'create' => Pages\CreateStaff::route('/create'),
            'view' => Pages\ViewStaff::route('/{record}'),
            'edit' => Pages\EditStaff::route('/{record}/edit'),
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