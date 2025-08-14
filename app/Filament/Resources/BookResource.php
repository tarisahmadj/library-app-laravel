<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use App\Models\Rating;
use App\Models\Author;  

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('author_id')
                    ->label('Author')
                    ->relationship('author', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('published_year')
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->prefix('$'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable(),

                // tampilkan nama author
                TextColumn::make('author.name')
                    ->label('Author')
                    ->searchable()
                    ->formatStateUsing(function ($state, $record) {
                        $topAuthors = Author::getTop10Ids();

                        if (in_array($record->author_id, $topAuthors)) {
                            return $state . ' <span style="color: gold;">⭐</span>';
                        }

                        return $state;
                    })
                    ->html(),

                // tampilkan nama category
                TextColumn::make('category.name')
                    ->searchable(),
                TextColumn::make('published_year'),
                TextColumn::make('price')
                    ->money()
                    ->sortable(),

                // Tambahkan kolom rata-rata rating
                TextColumn::make('ratings_avg_score')
                    ->label('Average Rating')
                    ->getStateUsing(fn ($record) => $record->ratings()->avg('score') ?? 0)
                    ->formatStateUsing(fn ($state) => round($state, 2))
                    ->sortable(),

                // Tambahkan kolom jumlah rating
                TextColumn::make('ratings_count')
                    ->label('Total Ratings')
                    ->getStateUsing(fn ($record) => $record->ratings()->count())
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
