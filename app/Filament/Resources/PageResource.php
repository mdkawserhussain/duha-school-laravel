<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Forms\Components as FormComponents;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use BackedEnum;
use UnitEnum;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|UnitEnum|null $navigationGroup = 'Pages';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Page Information')
                    ->schema([
                        FormComponents\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, $set, $get) {
                                if (!empty($state)) {
                                    // Handle both string and Stringable objects
                                    $titleValue = is_string($state) ? $state : (string) $state;
                                    $slug = str(trim($titleValue))->slug()->lower()->toString();
                                    // Ensure slug is not empty
                                    if (empty($slug)) {
                                        $slug = 'page-' . time();
                                    }
                                    $set('slug', $slug);
                                }
                            })
                            ->columnSpanFull(),

                        FormComponents\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, $set, $get) {
                                if (!empty($state)) {
                                    // Handle both string and Stringable objects
                                    $slugValue = is_string($state) ? $state : (string) $state;
                                    $slug = str(trim($slugValue))->slug()->lower()->toString();
                                    // Ensure slug is not empty
                                    if (empty($slug)) {
                                        // Fallback: use title if available, otherwise generate timestamp-based slug
                                        $title = $get('title');
                                        if (!empty($title)) {
                                            $slug = str(trim($title))->slug()->lower()->toString();
                                        }
                                        if (empty($slug)) {
                                            $slug = 'page-' . time();
                                        }
                                    }
                                    $set('slug', $slug);
                                }
                            })
                            ->dehydrateStateUsing(function ($state) {
                                // Always ensure we return a valid string slug
                                if (empty($state)) {
                                    return '';
                                }
                                
                                // Convert Stringable to string if needed
                                if (!is_string($state)) {
                                    $state = (string) $state;
                                }
                                
                                // Normalize the slug
                                $slug = str(trim($state))->slug()->lower()->toString();
                                
                                // Ensure slug is not empty
                                if (empty($slug)) {
                                    return 'page-' . time();
                                }
                                
                                return $slug;
                            })
                            ->rules([
                                'required',
                                'string',
                                'max:255',
                                'regex:/^[a-z0-9_-]+$/',
                            ])
                            ->helperText('Only lowercase letters, numbers, dashes, and underscores are allowed')
                            ->columnSpanFull(),

                        FormComponents\Select::make('parent_id')
                            ->label('Parent Page')
                            ->relationship('parent', 'title')
                            ->searchable()
                            ->preload()
                            ->helperText('Select a parent page to create a hierarchical structure')
                            ->columnSpan(1),

                        FormComponents\Select::make('page_category')
                            ->label('Page Category')
                            ->options([
                                'about-us' => 'About Us',
                                'academics' => 'Academics',
                                'facilities' => 'Facilities',
                                'activities-programs' => 'Activities & Programs',
                                'admissions' => 'Admissions',
                                'parent-engagement' => 'Parent Engagement',
                                'gallery' => 'Gallery',
                                'contact' => 'Contact',
                            ])
                            ->searchable()
                            ->helperText('Category for grouping related pages')
                            ->columnSpan(1),

                        FormComponents\Textarea::make('excerpt')
                            ->label('Excerpt')
                            ->maxLength(500)
                            ->rows(3)
                            ->helperText('Short summary for listing pages and meta descriptions')
                            ->columnSpanFull(),

                        FormComponents\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Components\Section::make('Hero Section')
                    ->description('Upload a hero image for the page header. This will be displayed at the top of the page.')
                    ->schema([
                        FormComponents\FileUpload::make('hero_image')
                            ->label('Hero Image')
                            ->image()
                            ->imageEditor()
                            ->directory('pages/hero')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(10240) // 10MB
                            ->helperText('Recommended size: 1920x1080 pixels or larger. This image will be displayed in the page hero section.')
                            ->columnSpanFull(),

                        FormComponents\TextInput::make('hero_badge')
                            ->label('Hero Badge Text')
                            ->maxLength(100)
                            ->placeholder('e.g., Since 2010 • Chattogram')
                            ->helperText('Optional badge text displayed above the title in the hero section')
                            ->columnSpan(1),

                        FormComponents\TextInput::make('hero_subtitle')
                            ->label('Hero Subtitle')
                            ->maxLength(255)
                            ->helperText('Optional subtitle displayed below the main title in the hero section')
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Components\Section::make('Featured Image')
                    ->description('Featured image displayed within the page content (different from hero image)')
                    ->schema([
                        FormComponents\FileUpload::make('featured_image')
                            ->label('Featured Image')
                            ->image()
                            ->imageEditor()
                            ->directory('pages/featured')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120) // 5MB
                            ->helperText('Featured image displayed within the page content area')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Components\Section::make('SEO Settings')
                    ->schema([
                        FormComponents\TextInput::make('meta_title')
                            ->maxLength(60)
                            ->helperText('Recommended: 50-60 characters'),

                        FormComponents\Textarea::make('meta_description')
                            ->maxLength(160)
                            ->rows(3)
                            ->helperText('Recommended: 150-160 characters'),

                        FormComponents\TextInput::make('og_image')
                            ->url()
                            ->helperText('Open Graph image URL for social sharing'),
                    ]),

                Components\Section::make('Menu Settings')
                    ->schema([
                        FormComponents\TextInput::make('menu_title')
                            ->label('Menu Title')
                            ->maxLength(255)
                            ->helperText('Override page title in navigation menu'),

                        FormComponents\Toggle::make('show_in_menu')
                            ->label('Show in Menu')
                            ->default(true)
                            ->helperText('Display this page in navigation menu'),

                        FormComponents\Select::make('menu_section')
                            ->label('Menu Section')
                            ->options([
                                'main' => 'Main Navigation',
                                'footer' => 'Footer',
                                'both' => 'Both',
                            ])
                            ->default('main')
                            ->required(),

                        FormComponents\TextInput::make('menu_order')
                            ->label('Menu Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first'),

                        FormComponents\TextInput::make('external_url')
                            ->label('External URL')
                            ->url()
                            ->helperText('Optional external link (overrides page URL)'),

                        FormComponents\Toggle::make('open_in_new_tab')
                            ->label('Open in New Tab')
                            ->default(false)
                            ->helperText('For external URLs'),
                    ])
                    ->columns(2),

                Components\Section::make('Publishing')
                    ->schema([
                        FormComponents\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->default('draft')
                            ->required(),

                        FormComponents\DateTimePicker::make('published_at')
                            ->label('Publish At')
                            ->default(now())
                            ->required(),

                        FormComponents\Toggle::make('is_featured')
                            ->label('Featured')
                            ->helperText('Mark as featured page'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->circular()
                    ->defaultImageUrl('/images/placeholder.svg'),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('page_category')
                    ->badge()
                    ->color('info')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('parent.title')
                    ->label('Parent Page')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('show_in_menu')
                    ->boolean()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published')
                    ->placeholder('All')
                    ->trueLabel('Published only')
                    ->falseLabel('Draft only'),
                Tables\Filters\SelectFilter::make('page_category')
                    ->label('Category')
                    ->options([
                        'about-us' => 'About Us',
                        'academics' => 'Academics',
                        'facilities' => 'Facilities',
                        'activities-programs' => 'Activities & Programs',
                        'admissions' => 'Admissions',
                        'parent-engagement' => 'Parent Engagement',
                        'gallery' => 'Gallery',
                        'contact' => 'Contact',
                    ]),
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
            ->defaultSort('updated_at', 'desc');
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'view' => Pages\ViewPage::route('/{record}'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function canViewAny(): bool
    {
        return static::currentUser()?->hasAnyRole(['admin', 'editor']) ?? false;
    }

    public static function canCreate(): bool
    {
        return static::currentUser()?->hasAnyRole(['admin', 'editor']) ?? false;
    }

    public static function canEdit($record): bool
    {
        return static::currentUser()?->hasAnyRole(['admin', 'editor']) ?? false;
    }

    public static function canDelete($record): bool
    {
        return static::currentUser()?->hasRole('admin') ?? false;
    }

    protected static function currentUser(): ?User
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user;
    }
}