<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author:id,name', 'category:id,name'])
            ->withAvg('ratings', 'score')
            ->withCount('ratings')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $books,
        ]);
    }

    public function show(Book $book)
    {
        $book->load(['author:id,name', 'category:id,name'])
             ->loadAvg('ratings', 'score')
             ->loadCount('ratings');

        return response()->json([
            'status' => 'success',
            'data' => $book,
        ]);
    }
}
