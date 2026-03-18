<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function statistics()
    {
        $totalBooks = \App\Models\CopyBook::count();
        $totalBorrowings = \App\Models\Borrow::count();
        
        $mostConsultedBooks = \App\Models\Book::orderBy('borrow_count', 'desc')->take(5)->get();
        
        $topCategories = \App\Models\Category::withCount('books')
            ->orderBy('books_count', 'desc')
            ->take(5)
            ->get();

        $degradedCount = \App\Models\CopyBook::where('is_degraded', true)->count();
        $healthyCount = $totalBooks - $degradedCount;

        return response()->json([
            'total_copies' => $totalBooks,
            'total_borrowings' => $totalBorrowings,
            'collection_state' => [
                'healthy' => $healthyCount,
                'degraded' => $degradedCount,
            ],
            'most_consulted_books' => $mostConsultedBooks,
            'top_categories' => $topCategories,
        ]);
    }

    public function degradedBooks()
    {
        $degradedCopies = \App\Models\CopyBook::with('book')
            ->where('is_degraded', true)
            ->get();

        return response()->json($degradedCopies);
    }
}
