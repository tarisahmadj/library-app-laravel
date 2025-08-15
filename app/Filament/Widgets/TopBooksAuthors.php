<?php
namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class TopBooksAuthors extends Widget
{
    protected static string $view = 'filament.widgets.top-books-authors';
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        return [
            'books'   => \App\Models\Book::getTop10(),
            'authors' => \App\Models\Author::getTop10(),
        ];
    }
}
