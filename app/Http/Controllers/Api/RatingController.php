<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Book;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function byBook(Book $book, Request $request)
    {
        $perPage = min((int)$request->get('per_page', 50), 200);
        return Rating::query()
            ->where('book_id', $book->id)
            ->select(['id','book_id','score','comment','created_at'])
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
