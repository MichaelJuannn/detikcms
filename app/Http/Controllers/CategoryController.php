<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('category.index', ['data' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view = view('category.create');
        return $view;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $categoryReq = $request->input('category');
        try {
            $category = Category::create([
                'category' => $categoryReq
            ]);
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return redirect()->route('categories.create', ['error' => 1]);
            }
        }
        return redirect()->route('categories.create', ['success' => 1]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $categoryModel, string $category)
    {

        $categoryRes = DB::table('categories')
            ->leftJoin('books_categories', 'categories.id', '=', 'books_categories.category_id')
            ->leftJoin('books', 'books.id', '=', 'books_categories.book_id')
            ->where('categories.category', $category)
            ->selectRaw('category, COUNT(books_categories.category_id) AS count')
            ->groupBy('category')
            ->first();
        // $book = $categoryRes->book()->get();
        return view('category.show', ['data' => $categoryRes]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $categoryModel, string $category)
    {

        return view('category.update', ['data' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $categoryModel, string $category)
    {
        $newCategory = $request->input('category');
        $updated = Category::where('category', $category)->first();
        $updated->update([
            'category' => $newCategory
        ]);
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $categoryModel, string $category)
    {
        $deleted = Category::where('category', $category)->delete();
        return redirect()->route('categories.index');
    }
}
