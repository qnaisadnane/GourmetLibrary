<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Book::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'slug'=>'required',
            'author'=>'required',
            'category_id'=>'required',
        ]);
        return Book::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Book::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);
        $book->update($request->all());
        return $book; 
    }

    public function search(Request $request){
        $q = $request->q;
        return Book::with('category')
                    ->where('title' ,'like' ,"%$q%")
                    ->orWhere('author' ,'like' ,"%$q%")
                    ->orWhereHas('category', function($query) use ($q) {
                        $query->where('name', 'like', "%$q%");
                    })
                    ->get();
    }

    public function popular(Request $request){
        $query = Book::with('category')->orderBy('borrow_count','desc');
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        return $query->take(5)->get();
    }

    public function latest(Request $request){
        $query = Book::with('category')->orderBy('created_at','desc');
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        return $query->take(5)->get();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Book::destroy($id);
        return response()->json([
        'message'=>'Book deleted'
        ]);
    }
}
