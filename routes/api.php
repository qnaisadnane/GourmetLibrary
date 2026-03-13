<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::apiResource('categories',CategoryController::class);
Route::apiResource('books',BookController::class);

Route::get('/test', function () {
    return response()->json([
        'message' => 'API working'
    ]);
});