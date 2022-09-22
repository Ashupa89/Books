<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'genre',
        'description',
        'isbn',
        'image',
        'published',
        'publisher',
    ];

    public function scopeSearch($query, $key)
    {
        $query->where('title', 'LIKE', "%{$key}%")
            ->orWhere('author', 'LIKE', "%{$key}%")
            ->orWhere('published', 'LIKE', "%{$key}%")
            ->orWhere('isbn', 'LIKE', "%{$key}%")
            ->orWhere('genre', 'LIKE', "%{$key}%")
        ->orderBy("id","DESC");
    }

    public function scopeFilter($query, $col, $row)
    {
        $query->where($col, 'LIKE', "%{$row}%")->orderBy("id","DESC");
    }
}
