<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DersResource\Pages;
use App\Filament\Resources\DersResource\RelationManagers;
use App\Filament\Support\SlugFromField;
use App\Models\Ders;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DersResource extends Resource
{
    protected static ?string $model = Ders::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('ustaz_id')
                    ->relationship('ustaz', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('topic_id')
                    ->relationship('topic', 'name')
                    ->searchable()
                    ->preload(),
                ...SlugFromField::titleSlugFields(),
                Forms\Components\Textarea::make('description')
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('cover_image')
                    ->image()
                    ->disk('public')
                    ->directory('derses/covers'),
                Forms\Components\FileUpload::make('pdf_file')
                    ->label('PDF')
                    ->disk('public')
                    ->directory('derses/pdfs')
                    ->required()
                    ->acceptedFileTypes(['application/pdf'])
                    ->rules(['mimetypes:application/pdf'])
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('pdf_page_count')
                    ->label('PDF page count')
                    ->numeric()
                    ->disabled()
                    ->dehydrated()
                    ->helperText('Detected automatically when a PDF is uploaded.'),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_published')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ustaz.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('topic.name')
                    ->sortable()
                    ->searchable()
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('episodes_count')
                    ->counts('episodes')
                    ->label('Episodes'),
                Tables\Columns\TextColumn::make('pdf_page_count')
                    ->label('Pages')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('ustaz_id')
                    ->relationship('ustaz', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('topic_id')
                    ->relationship('topic', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('is_published'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\EpisodesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDers::route('/'),
            'create' => Pages\CreateDers::route('/create'),
            'edit' => Pages\EditDers::route('/{record}/edit'),
        ];
    }
}
