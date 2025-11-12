<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CareerApplicationResource\Pages;
use App\Models\CareerApplication;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;
use UnitEnum;

class CareerApplicationResource extends Resource
{
    protected static ?string $model = CareerApplication::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    protected static string|UnitEnum|null $navigationGroup = 'Applications';

    protected static ?int $navigationSort = 2;

    protected static ?string $label = 'Career Applications';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Application Details')
                    ->schema([
                        Components\TextInput::make('job_title')
                            ->required()
                            ->maxLength(255),

                        Components\TextInput::make('applicant_name')
                            ->required()
                            ->maxLength(255),

                        Components\TextInput::make('email')
                            ->required()
                            ->email()
                            ->maxLength(255),

                        Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(20),

                        Components\Textarea::make('cover_letter')
                            ->maxLength(2000)
                            ->rows(6)
                            ->columnSpanFull(),

                        Components\FileUpload::make('resume_path')
                            ->label('Resume/CV')
                            ->required()
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(5120) // 5MB
                            ->directory('resumes')
                            ->visibility('private')
                            ->helperText('Upload your resume in PDF format (Max 5MB)'),
                    ])
                    ->columns(2),

                Components\Section::make('Application Status')
                    ->schema([
                        Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending Review',
                                'reviewed' => 'Reviewed',
                                'shortlisted' => 'Shortlisted',
                                'rejected' => 'Rejected',
                            ])
                            ->default('pending')
                            ->required(),

                        Components\DateTimePicker::make('reviewed_at')
                            ->label('Reviewed At'),

                        Components\Textarea::make('review_notes')
                            ->label('Review Notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('job_title')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('applicant_name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'reviewed' => 'info',
                        'shortlisted' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Applied At'),

                Tables\Columns\TextColumn::make('reviewed_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Review',
                        'reviewed' => 'Reviewed',
                        'shortlisted' => 'Shortlisted',
                        'rejected' => 'Rejected',
                    ]),

                Tables\Filters\SelectFilter::make('job_title')
                    ->label('Position')
                    ->options([
                        'Islamic Studies Teacher' => 'Islamic Studies Teacher',
                        'Mathematics Teacher' => 'Mathematics Teacher',
                        'Administrative Assistant' => 'Administrative Assistant',
                        'Science Laboratory Technician' => 'Science Laboratory Technician',
                    ]),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\Action::make('download_resume')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->url(fn (CareerApplication $record): string => route('admin.career-applications.download-resume', $record))
                    ->openUrlInNewTab()
                    ->visible(fn (CareerApplication $record): bool => $record->resume_path),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListCareerApplications::route('/'),
            'create' => Pages\CreateCareerApplication::route('/create'),
            'view' => Pages\ViewCareerApplication::route('/{record}'),
            'edit' => Pages\EditCareerApplication::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasAnyRole(['admin', 'admissions_officer']) ?? false;
    }

    public static function canCreate(): bool
    {
        return false; // Applications are created by users, not admins
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->hasAnyRole(['admin', 'admissions_officer']) ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }
}