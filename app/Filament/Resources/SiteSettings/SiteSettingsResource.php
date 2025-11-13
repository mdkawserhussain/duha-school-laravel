<?php

namespace App\Filament\Resources\SiteSettings;

use App\Filament\Resources\SiteSettings\Pages\CreateSiteSettings;
use App\Filament\Resources\SiteSettings\Pages\EditSiteSettings;
use App\Filament\Resources\SiteSettings\Pages\ListSiteSettings;
use App\Filament\Resources\SiteSettings\Tables\SiteSettingsTable;
use App\Models\SiteSettings;
use BackedEnum;
use Filament\Forms\Components as FormComponents;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SiteSettingsResource extends Resource
{
    protected static ?string $model = SiteSettings::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Site Settings';

    protected static ?int $navigationSort = 100;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Site Information')
                    ->icon('heroicon-o-information-circle')
                    ->description('Configure your site name and description')
                    ->schema([
                        FormComponents\TextInput::make('site_name')
                            ->label('Site Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Al-Maghrib International School')
                            ->helperText('This name will be used throughout the website and in search results.')
                            ->columnSpanFull(),
                        FormComponents\Textarea::make('site_description')
                            ->label('Site Description')
                            ->rows(3)
                            ->placeholder('A brief description of your school...')
                            ->helperText('A short description that appears in search results and social media shares.')
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Components\Section::make('Logo')
                    ->icon('heroicon-o-photo')
                    ->description('Upload your site logo. If no logo is uploaded, a placeholder from Unsplash will be used.')
                    ->schema([
                        FormComponents\FileUpload::make('logo')
                            ->label('Site Logo')
                            ->image()
                            ->directory('logos')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/svg+xml'])
                            ->maxSize(2048)
                            ->helperText('Recommended size: 200x200px. Maximum file size: 2MB. Supported formats: PNG, JPEG, JPG, SVG.')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '1:1',
                            ])
                            ->disk('public')
                            ->dehydrated(false)
                            ->storeFileNamesIn('logo_filename')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Components\Section::make('Contact Information')
                    ->icon('heroicon-o-envelope')
                    ->description('Set up contact details that will be displayed on the website')
                    ->schema([
                        FormComponents\TextInput::make('contact_email')
                            ->label('Contact Email')
                            ->email()
                            ->maxLength(255)
                            ->placeholder('info@almaghribinternationalschool.com')
                            ->helperText('This email will be displayed in the footer and contact sections.')
                            ->columnSpan(1),
                        FormComponents\TextInput::make('contact_phone')
                            ->label('Contact Phone')
                            ->tel()
                            ->maxLength(255)
                            ->placeholder('+880-1766-500001')
                            ->helperText('Include country code and format for international display.')
                            ->columnSpan(1),
                        FormComponents\Textarea::make('address')
                            ->label('Address')
                            ->rows(3)
                            ->placeholder('House-131/1, Road-01, South Khulshi, Chittagong, Bangladesh')
                            ->helperText('Full address that will be displayed in the footer.')
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return SiteSettingsTable::configure($table);
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
            'index' => ListSiteSettings::route('/'),
            'create' => CreateSiteSettings::route('/create'),
            'edit' => EditSiteSettings::route('/{record}/edit'),
        ];
    }
}
