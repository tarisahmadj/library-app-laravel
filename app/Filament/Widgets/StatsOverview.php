<?php

namespace App\Filament\Widgets;

use App\Models\Author;
use App\Models\Book;
use App\Models\Rating;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $booksCount = Book::count();
        $authorsCount = Author::count();
        
        // Ambil rata-rata score dari tabel ratings (0-10)
        $averageRating = Rating::avg('score') ?? 0;
        $ratingPercentage = round(($averageRating / 10) * 100, 2);

        return [
            Card::make('Total Books', $booksCount)
                ->description('Jumlah semua buku')
                ->descriptionIcon('heroicon-o-book-open')
                ->color('success'),

            Card::make('Total Authors', $authorsCount)
                ->description('Jumlah semua penulis')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('primary'),

            Card::make('Rating (%)', "{$ratingPercentage}%")
                ->description('Rata-rata rating dalam persen')
                ->descriptionIcon('heroicon-o-star')
                ->color('warning'),
        ];
    }
}
