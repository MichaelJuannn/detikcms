<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Book extends Model
{
    protected $fillable = ['id', 'user_id', 'title', 'description', 'quantity', 'file', 'cover'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsToMany(Category::class, 'books_categories', 'book_id', 'category_id');
    }
    use HasFactory;
}
