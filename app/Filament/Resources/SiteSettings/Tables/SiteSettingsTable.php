<?php

namespace App\Filament\Resources\SiteSettings\Tables;

use App\Filament\Resources\SiteSettings\SiteSettingsResource;
use App\Models\SiteSettings;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiteSettingsTable
{
    public static function configure(Table $table): Table
    {
        $settings = SiteSettings::first();
        
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->getStateUsing(function () use ($settings) {
                        return $settings && $settings->hasMedia('logo') 
                            ? $settings->getFirstMediaUrl('logo', 'thumb') 
                            : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=100&h=100&fit=crop&auto=format';
                    })
                    ->circular()
                    ->size(60),
                TextColumn::make('site_name')
                    ->label('Site Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('contact_email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-o-envelope')
                    ->default('Not set'),
                TextColumn::make('contact_phone')
                    ->label('Phone')
                    ->searchable()
                    ->icon('heroicon-o-phone')
                    ->default('Not set'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->emptyStateHeading('No settings found')
            ->emptyStateDescription('Create your site settings to get started.')
            ->emptyStateIcon('heroicon-o-cog-6-tooth')
                    ->emptyStateActions([
                Action::make('create')
                    ->label('Create Settings')
                    ->url(fn () => SiteSettingsResource::getUrl('create'))
                    ->icon('heroicon-o-plus')
                    ->visible(fn () => SiteSettings::count() === 0),
            ]);
    }
}
