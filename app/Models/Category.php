<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category'];
    public function book()
    {
        return $this->belongsToMany(Book::class, 'books_categories', 'book_id', 'category_id');
    }
    use HasFactory;
}
