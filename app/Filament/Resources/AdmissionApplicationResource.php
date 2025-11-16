<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdmissionApplicationResource\Pages;
use App\Models\AdmissionApplication;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Forms\Components as FormComponents;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;
use UnitEnum;

class AdmissionApplicationResource extends Resource
{
    protected static ?string $model = AdmissionApplication::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-plus';

    protected static string|UnitEnum|null $navigationGroup = 'Applications';

    protected static ?int $navigationSort = 1;

    protected static ?string $label = 'Admission Applications';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Application Details')
                    ->schema([
                        FormComponents\TextInput::make('parent_name')
                            ->required()
                            ->maxLength(255),

                        FormComponents\TextInput::make('child_name')
                            ->required()
                            ->maxLength(255),

                        FormComponents\DatePicker::make('child_dob')
                            ->required()
                            ->maxDate(now()->subYears(3))
                            ->minDate(now()->subYears(18)),

                        FormComponents\TextInput::make('grade_applied')
                            ->required()
                            ->maxLength(50),

                        FormComponents\TextInput::make('phone')
                            ->required()
                            ->tel()
                            ->maxLength(20),

                        FormComponents\TextInput::make('email')
                            ->required()
                            ->email()
                            ->maxLength(255),

                        FormComponents\Textarea::make('message')
                            ->maxLength(1000)
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Components\Section::make('Supporting Documents')
                    ->schema([
                        FormComponents\Placeholder::make('documents_info')
                            ->label('')
                            ->content('Documents uploaded by the applicant will appear here when available.'),

                        FormComponents\Repeater::make('documents')
                            ->schema([
                                FormComponents\TextInput::make('name')
                                    ->required(),
                                FormComponents\TextInput::make('path')
                                    ->required(),
                                FormComponents\TextInput::make('type')
                                    ->required(),
                            ])
                            ->columns(3)
                            ->disabled()
                            ->dehydrated(false)
                            ->defaultItems(0),
                    ]),

                Components\Section::make('Application Status')
                    ->schema([
                        FormComponents\Select::make('status')
                            ->options([
                                'pending' => 'Pending Review',
                                'reviewed' => 'Reviewed',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->default('pending')
                            ->required(),

                        FormComponents\DateTimePicker::make('reviewed_at')
                            ->label('Reviewed At'),

                        FormComponents\Textarea::make('review_notes')
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
                Tables\Columns\TextColumn::make('child_name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('parent_name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('grade_applied')
                    ->badge()
                    ->color('primary'),

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
                        'approved' => 'success',
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
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),

                Tables\Filters\SelectFilter::make('grade_applied')
                    ->options([
                        'Kindergarten' => 'Kindergarten',
                        'Grade 1' => 'Grade 1',
                        'Grade 2' => 'Grade 2',
                        'Grade 3' => 'Grade 3',
                        'Grade 4' => 'Grade 4',
                        'Grade 5' => 'Grade 5',
                        'Grade 6' => 'Grade 6',
                        'Grade 7' => 'Grade 7',
                        'Grade 8' => 'Grade 8',
                        'Grade 9' => 'Grade 9',
                        'Grade 10' => 'Grade 10',
                        'Grade 11' => 'Grade 11',
                        'Grade 12' => 'Grade 12',
                    ]),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\Action::make('download_documents')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->url(fn (AdmissionApplication $record): string => route('admin.applications.download-documents', $record))
                    ->openUrlInNewTab()
                    ->visible(fn (AdmissionApplication $record): bool => $record->documents && count($record->documents) > 0),
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
            'index' => Pages\ListAdmissionApplications::route('/'),
            'create' => Pages\CreateAdmissionApplication::route('/create'),
            'view' => Pages\ViewAdmissionApplication::route('/{record}'),
            'edit' => Pages\EditAdmissionApplication::route('/{record}/edit'),
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

    public static function shouldRegisterNavigation(): bool
    {
        return true;
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