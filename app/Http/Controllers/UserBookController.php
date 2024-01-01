<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use Illuminate\Http\UploadedFile;

class UserBookController extends Controller
{
    public function index(Request $request)
    {
        $userid = Auth::id();
        $categories = Category::all();
        $queryUrl = $request->query('category');
        if (!$queryUrl) {
            $books = DB::table('books')
                ->join('books_categories', 'books.id', '=', 'books_categories.book_id')
                ->join('categories', 'categories.id', '=', 'books_categories.category_id')
                ->selectRaw('books.*, GROUP_CONCAT(categories.category SEPARATOR ", ") as categories')
                ->where('user_id', $userid)
                ->groupBy('books.id')
                ->get();
            return view('dashboard', ['data' => $books, 'categories' => $categories]);
        }
        $books = DB::table('books')
            ->join('books_categories', 'books.id', '=', 'books_categories.book_id')
            ->join('categories', 'categories.id', '=', 'books_categories.category_id')
            ->where('categories.category', '=', $queryUrl)
            ->where('user_id', $userid)
            ->selectRaw('books.*, GROUP_CONCAT(categories.category SEPARATOR ", ") as categories')
            ->groupBy('books.id')
            ->get();

        return view('dashboard', ['data' => $books, 'categories' => $categories]);
    }
    public function create()
    {
        //
        $categories = Category::all();
        $view = view('dashboard.create', ['data' => $categories]);
        return $view;
    }
    public function store(Request $request)
    {
        $user_id = Auth::id();
        $title = $request->input('title');
        $category = $request->input('category');
        $description = $request->input('description');
        $quantity = $request->input('quantity');

        //file req
        $file = $request->file('file');
        $cover = $request->file('cover');

        $file_path = saveUserFile($file);
        $cover_path = saveUserCover($cover);

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
        return redirect()->route('dashboard', ['success' => 1]);
    }
    public function show(Book $bookModel, string $dashboard)
    {
        $bookRes = DB::table('books')
            ->join('books_categories', 'books.id', '=', 'books_categories.book_id')
            ->join('categories', 'categories.id', '=', 'books_categories.category_id')
            ->where('books.id', '=', $dashboard)
            ->selectRaw('books.*, GROUP_CONCAT(categories.category SEPARATOR ", ") as categories')
            ->groupBy('books.id')
            ->first();
        return view('dashboard.show', ['data' => $bookRes]);
    }
    public function edit(Book $bookModel, string $book)
    {
        $categories = Category::all();
        $bookRes = Book::where('id', $book)->select('title', 'id')->first();
        return view('dashboard.update', ['data' => $bookRes, 'category' => $categories]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $bookModel, string $dashboard)
    {
        $title = $request->input('title');
        $category = $request->input('category');
        $description = $request->input('description');
        $quantity = $request->input('quantity');

        //file req
        $file = $request->file('file');
        $cover = $request->file('cover');

        $file_path = saveUserFile($file);
        $cover_path = saveUserCover($cover);

        $category = Category::firstOrCreate(['category' => $category]);
        $updatedBook = Book::where('id', $dashboard)->first();
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

        return redirect()->route('dashboard.show', ['dashboard' => $dashboard]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $bookModel, string $dashboard)
    {
        $deleted = Book::where('id', $dashboard)->delete();
        return redirect()->route('dashboard');
    }
}
function saveUserCover(UploadedFile $cover)
{
    $cover_name = pathinfo($cover->getClientOriginalName(), PATHINFO_FILENAME);
    $saved_cover_name = $cover_name . '-' . time() . '.' . $cover->getClientOriginalExtension();
    return $cover_path = $cover->storeAs('cover_file', trim($saved_cover_name), 'public');
}
function saveUserFile(UploadedFile $file)
{
    $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $saved_file_name = $file_name . '_' . time() . '.' . $file->getClientOriginalExtension();
    return $file_path = $file->storeAs('book_file', trim($saved_file_name), 'public');
}
