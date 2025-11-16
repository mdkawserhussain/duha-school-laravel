<?php

namespace App\Filament\Resources\Announcements\Schemas;

use Filament\Forms\Components as FormComponents;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Announcement Details')
                    ->icon('heroicon-o-megaphone')
                    ->description('Create an announcement to display in the topbar')
                    ->schema([
                        FormComponents\Textarea::make('message')
                            ->label('Message')
                            ->required()
                            ->rows(2)
                            ->maxLength(500)
                            ->placeholder('Admission ongoing on Duha International School. Visit our campus to know more.')
                            ->helperText('The announcement message that will scroll in the topbar. Keep it concise.')
                            ->columnSpanFull(),
                        
                        FormComponents\TextInput::make('link')
                            ->label('Link URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://example.com/admission')
                            ->helperText('Optional: Make the announcement clickable by adding a URL.')
                            ->columnSpan(1),
                        
                        FormComponents\TextInput::make('link_text')
                            ->label('Link Text')
                            ->maxLength(50)
                            ->placeholder('Learn More')
                            ->helperText('Optional: Text to display for the link (if URL is provided).')
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Components\Section::make('Visibility & Scheduling')
                    ->icon('heroicon-o-calendar')
                    ->description('Control when and how the announcement is displayed')
                    ->schema([
                        FormComponents\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Only active announcements will be displayed.')
                            ->columnSpan(1),
                        
                        FormComponents\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first. Used for rotation when multiple announcements are active.')
                            ->columnSpan(1),
                        
                        FormComponents\DateTimePicker::make('starts_at')
                            ->label('Start Date/Time')
                            ->helperText('Optional: When to start showing this announcement. Leave blank to show immediately.')
                            ->timezone('Asia/Dhaka')
                            ->columnSpan(1),
                        
                        FormComponents\DateTimePicker::make('expires_at')
                            ->label('Expiration Date/Time')
                            ->helperText('Optional: When to stop showing this announcement. Leave blank for no expiration.')
                            ->timezone('Asia/Dhaka')
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }
}
