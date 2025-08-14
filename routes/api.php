<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\RatingController;

Route::get('books', [BookController::class, 'index']);
Route::get('books/{book}/ratings', [RatingController::class, 'byBook']);
