<?php

namespace App\Filament\Resources\NavigationItems\Schemas;

use Filament\Forms\Components as FormComponents;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;

class NavigationItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Navigation Item Information')
                    ->schema([
                        FormComponents\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        FormComponents\TextInput::make('slug')
                            ->maxLength(255)
                            ->helperText('Optional slug for URL generation')
                            ->columnSpan(1),

                        FormComponents\Select::make('parent_id')
                            ->label('Parent Item')
                            ->relationship('parent', 'title')
                            ->searchable()
                            ->preload()
                            ->helperText('Select parent for nested menu')
                            ->columnSpan(1),

                        FormComponents\TextInput::make('route_name')
                            ->label('Route Name')
                            ->maxLength(255)
                            ->helperText('Laravel route name (e.g., home.index)')
                            ->columnSpan(1),

                        FormComponents\TextInput::make('url')
                            ->label('URL')
                            ->url()
                            ->maxLength(500)
                            ->helperText('External URL or internal path')
                            ->columnSpan(1),

                        FormComponents\TextInput::make('icon')
                            ->label('Icon')
                            ->maxLength(255)
                            ->helperText('Heroicon name (e.g., heroicon-o-home)')
                            ->columnSpan(1),

                        FormComponents\Select::make('section')
                            ->label('Menu Section')
                            ->options([
                                'main' => 'Main Navigation',
                                'footer' => 'Footer',
                            ])
                            ->default('main')
                            ->required()
                            ->columnSpan(1),

                        FormComponents\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->helperText('Lower numbers appear first')
                            ->columnSpan(1),

                        FormComponents\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->columnSpan(1),

                        FormComponents\Toggle::make('is_external')
                            ->label('External Link')
                            ->default(false)
                            ->helperText('Mark as external URL')
                            ->columnSpan(1),

                        FormComponents\Toggle::make('target_blank')
                            ->label('Open in New Tab')
                            ->default(false)
                            ->helperText('For external links')
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }
}