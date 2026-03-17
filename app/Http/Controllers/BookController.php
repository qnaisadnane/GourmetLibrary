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
        return Book::where('title' ,'like' ,"%$q%")
                    ->orwhere('author' ,'like' ,"%$q%")
                    ->get();
                    }

    public function popular(){
        return Book::orderby('borrow_count','desc')
                    ->take(5)
                    ->get();
    }

    // public function latest(){
    //     return Book::orderby('category_id','desc')
    //                 ->take(5)
    //                 ->get();
    // }
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
