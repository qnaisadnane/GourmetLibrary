<?php
use App\Models\Category;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public Read-Only Routes for Gourmands (and everyone)
Route::get('/books/popular', [BookController::class, 'popular']);
Route::get('/books/latest', [BookController::class, 'latest']);
Route::get('/books/search', [BookController::class, 'search']);
Route::get('/categories/{id}/books', function ($id) {
    return Category::findOrFail($id)->books;
});


// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Admin Only Routes
    Route::middleware('isAdmin')->group(function () {
        Route::get('/admin/statistics', [\App\Http\Controllers\AdminController::class, 'statistics']);
        Route::get('/admin/books/degraded', [\App\Http\Controllers\AdminController::class, 'degradedBooks']);
        Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
        Route::apiResource('books', BookController::class)->except(['index', 'show']);
        Route::apiResource('borrows', BorrowController::class); 
    });
});

