<?php
use App\Models\Category;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/books/search', [BookController::class,'search']);

Route::apiResource('categories',CategoryController::class);
Route::apiResource('books',BookController::class);
Route::apiResource('borrows', BorrowController::class);

Route::get('/test', function () {
    return response()->json([
        'message' => 'API working'
    ]);
});

Route::get('/categories/{id}/books', function ($id) {
    return Category::findOrFail($id)->books;
});
