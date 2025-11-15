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
                Components\Tabs::make('SettingsTabs')
                    ->tabs([
                        // General Tab
                        Components\Tabs\Tab::make('General')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Components\Section::make('Website Information')
                                    ->schema([
                                        FormComponents\TextInput::make('website_name')
                                            ->label('Website Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Duha International School')
                                            ->helperText('This name will be used throughout the website and in search results.')
                                            ->columnSpanFull(),
                                        FormComponents\TextInput::make('website_tagline')
                                            ->label('Website Tagline')
                                            ->maxLength(255)
                                            ->placeholder('Excellence in Islamic Education')
                                            ->columnSpanFull(),
                                        FormComponents\Textarea::make('website_description')
                                            ->label('Website Description')
                                            ->rows(3)
                                            ->placeholder('A brief description of your school...')
                                            ->helperText('A short description that appears in search results and social media shares.')
                                            ->maxLength(1000)
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(1),
                            ]),

                        // Branding Tab
                        Components\Tabs\Tab::make('Branding')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Components\Section::make('Logo & Favicon')
                                    ->schema([
                                        FormComponents\FileUpload::make('logo')
                                            ->label('Site Logo')
                                            ->image()
                                            ->directory('site-settings/logos')
                                            ->visibility('public')
                                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/svg+xml', 'image/webp'])
                                            ->maxSize(2048)
                                            ->helperText('Recommended size: 200x200px. Maximum file size: 2MB.')
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                null,
                                                '1:1',
                                            ])
                                            ->disk('public')
                                            ->dehydrated(false)
                                            ->columnSpan(1),
                                        FormComponents\FileUpload::make('favicon')
                                            ->label('Favicon')
                                            ->image()
                                            ->directory('site-settings/favicons')
                                            ->visibility('public')
                                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/svg+xml', 'image/x-icon', 'image/vnd.microsoft.icon'])
                                            ->maxSize(1024)
                                            ->helperText('Recommended size: 32x32px or 16x16px. Maximum file size: 1MB.')
                                            ->disk('public')
                                            ->dehydrated(false)
                                            ->columnSpan(1),
                                    ])
                                    ->columns(2),
                            ]),

                        // Contact Tab
                        Components\Tabs\Tab::make('Contact')
                            ->icon('heroicon-o-envelope')
                            ->schema([
                                Components\Section::make('Contact Information')
                                    ->schema([
                                        FormComponents\TextInput::make('primary_email')
                                            ->label('Primary Email')
                                            ->email()
                                            ->maxLength(255)
                                            ->placeholder('info@duhainternationalschool.com')
                                            ->columnSpan(1),
                                        FormComponents\TextInput::make('secondary_email')
                                            ->label('Secondary Email')
                                            ->email()
                                            ->maxLength(255)
                                            ->columnSpan(1),
                                        FormComponents\TextInput::make('primary_phone')
                                            ->label('Primary Phone')
                                            ->tel()
                                            ->maxLength(20)
                                            ->placeholder('+880-1766-500001')
                                            ->columnSpan(1),
                                        FormComponents\TextInput::make('secondary_phone')
                                            ->label('Secondary Phone')
                                            ->tel()
                                            ->maxLength(20)
                                            ->columnSpan(1),
                                        FormComponents\Textarea::make('physical_address')
                                            ->label('Physical Address')
                                            ->rows(3)
                                            ->placeholder('House-131/1, Road-01, South Khulshi, Chittagong, Bangladesh')
                                            ->maxLength(500)
                                            ->columnSpanFull(),
                                        FormComponents\Textarea::make('business_hours')
                                            ->label('Business Hours')
                                            ->rows(2)
                                            ->placeholder('Sun-Thu: 9AM - 5PM\nFri & Sat: Closed')
                                            ->maxLength(500)
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                            ]),

                        // Social Media Tab
                        Components\Tabs\Tab::make('Social Media')
                            ->icon('heroicon-o-share')
                            ->schema([
                                Components\Section::make('Social Media Links')
                                    ->schema([
                                        FormComponents\TextInput::make('social_media_links.facebook')
                                            ->label('Facebook URL')
                                            ->url()
                                            ->maxLength(255)
                                            ->placeholder('https://facebook.com/yourpage')
                                            ->columnSpan(1),
                                        FormComponents\TextInput::make('social_media_links.twitter')
                                            ->label('Twitter/X URL')
                                            ->url()
                                            ->maxLength(255)
                                            ->columnSpan(1),
                                        FormComponents\TextInput::make('social_media_links.instagram')
                                            ->label('Instagram URL')
                                            ->url()
                                            ->maxLength(255)
                                            ->columnSpan(1),
                                        FormComponents\TextInput::make('social_media_links.youtube')
                                            ->label('YouTube URL')
                                            ->url()
                                            ->maxLength(255)
                                            ->columnSpan(1),
                                        FormComponents\TextInput::make('social_media_links.linkedin')
                                            ->label('LinkedIn URL')
                                            ->url()
                                            ->maxLength(255)
                                            ->columnSpan(1),
                                    ])
                                    ->columns(2),
                            ]),

                        // SEO Tab
                        Components\Tabs\Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Components\Section::make('Meta Tags')
                                    ->schema([
                                        FormComponents\TextInput::make('meta_title')
                                            ->label('Meta Title')
                                            ->maxLength(255)
                                            ->helperText('Title for search engines (recommended: 50-60 characters)')
                                            ->columnSpanFull(),
                                        FormComponents\Textarea::make('meta_description')
                                            ->label('Meta Description')
                                            ->rows(2)
                                            ->maxLength(500)
                                            ->helperText('Description for search engines (recommended: 150-160 characters)')
                                            ->columnSpanFull(),
                                        FormComponents\Textarea::make('meta_keywords')
                                            ->label('Meta Keywords')
                                            ->rows(2)
                                            ->maxLength(500)
                                            ->helperText('Comma-separated keywords')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(1),
                                Components\Section::make('Open Graph')
                                    ->schema([
                                        FormComponents\TextInput::make('og_title')
                                            ->label('OG Title')
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                        FormComponents\Textarea::make('og_description')
                                            ->label('OG Description')
                                            ->rows(2)
                                            ->maxLength(500)
                                            ->columnSpanFull(),
                                        FormComponents\FileUpload::make('og_image')
                                            ->label('OG Image')
                                            ->image()
                                            ->directory('site-settings/og-images')
                                            ->visibility('public')
                                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/webp'])
                                            ->maxSize(2048)
                                            ->helperText('Recommended size: 1200x630px for social media sharing.')
                                            ->disk('public')
                                            ->dehydrated(false)
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(1),
                                Components\Section::make('Canonical URL')
                                    ->schema([
                                        FormComponents\TextInput::make('canonical_url')
                                            ->label('Canonical URL')
                                            ->url()
                                            ->maxLength(500)
                                            ->helperText('Default canonical URL for the site')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(1),
                            ]),

                        // Theme Tab
                        Components\Tabs\Tab::make('Theme')
                            ->icon('heroicon-o-paint-brush')
                            ->schema([
                                Components\Section::make('Color Scheme')
                                    ->schema([
                                        FormComponents\ColorPicker::make('primary_color')
                                            ->label('Primary Color')
                                            ->default('#0F4C81')
                                            ->required()
                                            ->columnSpan(1),
                                        FormComponents\ColorPicker::make('secondary_color')
                                            ->label('Secondary Color')
                                            ->default('#1E3A8A')
                                            ->required()
                                            ->columnSpan(1),
                                        FormComponents\ColorPicker::make('accent_color')
                                            ->label('Accent Color')
                                            ->default('#F4C430')
                                            ->required()
                                            ->columnSpan(1),
                                    ])
                                    ->columns(3),
                            ]),

                        // Localization Tab
                        Components\Tabs\Tab::make('Localization')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                Components\Section::make('Language & Currency')
                                    ->schema([
                                        FormComponents\Select::make('default_language')
                                            ->label('Default Language')
                                            ->options([
                                                'en' => 'English',
                                                'bn' => 'Bengali',
                                                'ar' => 'Arabic',
                                            ])
                                            ->default('en')
                                            ->required()
                                            ->columnSpan(1),
                                        FormComponents\Select::make('default_currency')
                                            ->label('Default Currency')
                                            ->options([
                                                'USD' => 'USD - US Dollar',
                                                'EUR' => 'EUR - Euro',
                                                'GBP' => 'GBP - British Pound',
                                                'BDT' => 'BDT - Bangladeshi Taka',
                                                'SAR' => 'SAR - Saudi Riyal',
                                                'AED' => 'AED - UAE Dirham',
                                            ])
                                            ->default('USD')
                                            ->required()
                                            ->columnSpan(1),
                                        FormComponents\Select::make('timezone')
                                            ->label('Timezone')
                                            ->options([
                                                'UTC' => 'UTC',
                                                'Asia/Dhaka' => 'Asia/Dhaka (Bangladesh)',
                                                'Asia/Dubai' => 'Asia/Dubai (UAE)',
                                                'Asia/Riyadh' => 'Asia/Riyadh (Saudi Arabia)',
                                            ])
                                            ->default('UTC')
                                            ->required()
                                            ->searchable()
                                            ->columnSpan(1),
                                    ])
                                    ->columns(3),
                            ]),

                        // Advanced Tab
                        Components\Tabs\Tab::make('Advanced')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Components\Section::make('Analytics & Tracking')
                                    ->schema([
                                        FormComponents\TextInput::make('google_analytics_id')
                                            ->label('Google Analytics ID')
                                            ->maxLength(50)
                                            ->placeholder('G-XXXXXXXXXX')
                                            ->helperText('Enter your Google Analytics tracking ID')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(1),
                                Components\Section::make('Custom Code')
                                    ->schema([
                                        FormComponents\Textarea::make('custom_css')
                                            ->label('Custom CSS')
                                            ->rows(6)
                                            ->helperText('Add custom CSS that will be injected into the site header')
                                            ->columnSpanFull(),
                                        FormComponents\Textarea::make('custom_js')
                                            ->label('Custom JavaScript')
                                            ->rows(6)
                                            ->helperText('Add custom JavaScript that will be injected before closing body tag')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(1),
                                Components\Section::make('Footer Settings')
                                    ->schema([
                                        FormComponents\Textarea::make('footer_text')
                                            ->label('Footer Text')
                                            ->rows(3)
                                            ->maxLength(1000)
                                            ->columnSpanFull(),
                                        FormComponents\TextInput::make('copyright_notice')
                                            ->label('Copyright Notice')
                                            ->maxLength(255)
                                            ->placeholder('© {year} Duha International School. All rights reserved.')
                                            ->helperText('Use {year} to automatically insert current year')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(1),
                            ]),

                        // Maintenance Tab
                        Components\Tabs\Tab::make('Maintenance')
                            ->icon('heroicon-o-wrench-screwdriver')
                            ->schema([
                                Components\Section::make('Maintenance Mode')
                                    ->schema([
                                        FormComponents\Toggle::make('maintenance_mode')
                                            ->label('Enable Maintenance Mode')
                                            ->helperText('When enabled, visitors will see a maintenance page')
                                            ->default(false)
                                            ->columnSpanFull(),
                                        FormComponents\Textarea::make('maintenance_message')
                                            ->label('Maintenance Message')
                                            ->rows(3)
                                            ->maxLength(1000)
                                            ->placeholder('We are currently performing scheduled maintenance. Please check back soon.')
                                            ->columnSpanFull(),
                                        FormComponents\DateTimePicker::make('maintenance_scheduled_at')
                                            ->label('Scheduled Start')
                                            ->helperText('Optional: Schedule maintenance to start automatically')
                                            ->columnSpan(1),
                                        FormComponents\DateTimePicker::make('maintenance_scheduled_until')
                                            ->label('Scheduled End')
                                            ->helperText('Optional: Schedule maintenance to end automatically')
                                            ->columnSpan(1),
                                    ])
                                    ->columns(2),
                            ]),
                    ])
                    ->columnSpanFull(),
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
