<?php
use App\Models\Category;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);
});

Route::get('/books/popular', [BookController::class,'popular']);
Route::get('/books/latest', [BookController::class,'latest']);
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
