<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function user()
    {
        return $this->belongsTo('User');
    }
    public function category()
    {
        return $this->belongsToMany(Category::class, 'books_categories', 'book_id', 'category_id');
    }
    use HasFactory;
}
