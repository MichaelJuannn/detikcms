<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserBookController;
use App\Http\Middleware\AdminAccess;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(AdminAccess::class)->group(function () {
    Route::resource('dashboard/admin/books', BookController::class);
    Route::resource('dashboard/admin/categories', CategoryController::class);
    Route::get('/dashboard/admin/report', [BookController::class, 'printPDF'])->name('books.report');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::resource('dashboard', UserBookController::class);
});
Route::get('/dashboard', [UserBookController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
