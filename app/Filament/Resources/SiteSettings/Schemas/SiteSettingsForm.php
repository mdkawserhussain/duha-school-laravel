<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Schemas\Components;
use Filament\Schemas\Schema;

class SiteSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Site Information')
                    ->icon('heroicon-o-information-circle')
                    ->description('Configure your site name and description')
                    ->schema([
                        Components\TextInput::make('site_name')
                            ->label('Site Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Duha International School')
                            ->helperText('This name will be used throughout the website and in search results.')
                            ->columnSpanFull(),
                        Components\Textarea::make('site_description')
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
                        Components\FileUpload::make('logo')
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
                            ->dehydrated(false)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Components\Section::make('Contact Information')
                    ->icon('heroicon-o-envelope')
                    ->description('Set up contact details that will be displayed on the website')
                    ->schema([
                        Components\TextInput::make('contact_email')
                            ->label('Contact Email')
                            ->email()
                            ->maxLength(255)
                            ->placeholder('info@duhainternationalschool.com')
                            ->helperText('This email will be displayed in the footer and contact sections.')
                            ->columnSpan(1),
                        Components\TextInput::make('contact_phone')
                            ->label('Contact Phone')
                            ->tel()
                            ->maxLength(255)
                            ->placeholder('+880-1766-500001')
                            ->helperText('Include country code and format for international display.')
                            ->columnSpan(1),
                        Components\Textarea::make('address')
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
}
