<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $queryUrl = $request->query('category');
        if (!$queryUrl) {
            $books = DB::table('books')
                ->join('books_categories', 'books.id', '=', 'books_categories.book_id')
                ->join('categories', 'categories.id', '=', 'books_categories.category_id')
                ->selectRaw('books.*, GROUP_CONCAT(categories.category SEPARATOR ", ") as categories')
                ->groupBy('books.id')
                ->get();
            return view('book.index', ['data' => $books, 'categories' => $categories]);
        }
        $books = DB::table('books')
            ->join('books_categories', 'books.id', '=', 'books_categories.book_id')
            ->join('categories', 'categories.id', '=', 'books_categories.category_id')
            ->where('categories.category', '=', $queryUrl)
            ->selectRaw('books.*, GROUP_CONCAT(categories.category SEPARATOR ", ") as categories')
            ->groupBy('books.id')
            ->get();

        return view('book.index', ['data' => $books, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        $view = view('book.create', ['data' => $categories]);
        return $view;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $user_id = Auth::id();
        $title = $request->input('title');
        $category = $request->input('category');
        $description = $request->input('description');
        $quantity = $request->input('quantity');

        //file req
        $file = $request->file('file');
        $cover = $request->file('cover');

        $file_path = saveFile($file);
        $cover_path = saveCover($cover);

        //query
        $category = Category::firstOrCreate(['category' => $category]);
        $book = Book::create([
            'title' => $title,
            'description' => $description,
            'quantity' => $quantity,
            'file' => $file_path,
            'cover' => $cover_path,
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
        $bookRes = DB::table('books')
            ->join('books_categories', 'books.id', '=', 'books_categories.book_id')
            ->join('categories', 'categories.id', '=', 'books_categories.category_id')
            ->where('books.id', '=', $book)
            ->selectRaw('books.*, GROUP_CONCAT(categories.category SEPARATOR ", ") as categories')
            ->groupBy('books.id')
            ->first();
        return view('book.show', ['data' => $bookRes]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $bookModel, string $book)
    {
        $categories = Category::all();
        $bookRes = Book::where('id', $book)->select('title', 'id')->first();
        return view('book.update', ['data' => $bookRes, 'category' => $categories]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $bookModel, string $book)
    {
        $title = $request->input('title');
        $category = $request->input('category');
        $description = $request->input('description');
        $quantity = $request->input('quantity');

        //file req
        $file = $request->file('file');
        $cover = $request->file('cover');

        $file_path = saveFile($file);
        $cover_path = saveCover($cover);

        $category = Category::firstOrCreate(['category' => $category]);
        $updatedBook = Book::where('id', $book)->first();
        $updatedBook->update(
            [
                'title' => $title,
                'description' => $description,
                'quantity' => $quantity,
                'file' => $file_path,
                'cover' => $cover_path,
            ]
        );
        $categoryId = [$category->id];
        $updatedBook->category()->sync($categoryId);

        return redirect()->route('books.show', ['book' => $book]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $bookModel, string $book)
    {
        $deleted = Book::where('id', $book)->delete();
        return redirect()->route('books.index');
    }
}
function saveCover(UploadedFile $cover)
{
    $cover_name = pathinfo($cover->getClientOriginalName(), PATHINFO_FILENAME);
    $saved_cover_name = $cover_name . '-' . time() . '.' . $cover->getClientOriginalExtension();
    return $cover_path = $cover->storeAs('cover_file', trim($saved_cover_name), 'public');
}
function saveFile(UploadedFile $file,)
{
    $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $saved_file_name = $file_name . '_' . time() . '.' . $file->getClientOriginalExtension();
    return $file_path = $file->storeAs('book_file', trim($saved_file_name), 'public');
}
