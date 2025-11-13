<?php

namespace App\Filament\Resources\HomePageContents;

use App\Filament\Resources\HomePageContents\Pages\CreateHomePageContent;
use App\Filament\Resources\HomePageContents\Pages\EditHomePageContent;
use App\Filament\Resources\HomePageContents\Pages\ListHomePageContents;
use App\Filament\Resources\HomePageContents\Schemas\HomePageContentForm;
use App\Filament\Resources\HomePageContents\Tables\HomePageContentsTable;
use App\Models\HomePageContent;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HomePageContentResource extends Resource
{
    protected static ?string $model = HomePageContent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return HomePageContentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HomePageContentsTable::configure($table);
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
            'index' => ListHomePageContents::route('/'),
            'create' => CreateHomePageContent::route('/create'),
            'edit' => EditHomePageContent::route('/{record}/edit'),
        ];
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
