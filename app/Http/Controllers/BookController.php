<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $books = Book::all();
        return $books;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $view = view('book.book');
        return $view;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $user_id = Auth::id();
        //
        $title = $request->input('title');
        $category = $request->input('category');
        $description = $request->input('description');
        $quantity = $request->input('quantity');
        $file = $request->input('file');
        $cover = $request->input('cover');
        //query
        $category = Category::firstOrCreate(['category' => $category]);
        $book = Book::create([
            'title' => $title,
            'category' => $category,
            'description' => $description,
            'quantity' => $quantity,
            'file' => $file,
            'cover' => $cover,
            'user_id' => $user_id,
        ]);
        $categoryId = [$category->id];
        $book->category()->attach($categoryId);
        return redirect()->route('books.create', ['success' => 1]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $bookModel, string $book)
    {
        $bookRes = Book::where('id', $book)->first();

        return $bookRes;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $bookModel, string $book)
    {
        $deleted = Book::where('id', $book)->delete();
        return $deleted;
    }
}
