<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return $categories;
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

        $categoryRes = Category::where('category', $category)->first();
        $book = $categoryRes->book()->get();
        return $book;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $categoryModel, string $category)
    {
        $deleted = Category::where('category', $category)->delete();
        return redirect()->back();
    }
}
