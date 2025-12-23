<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'genre',
        'description',
        'status',
        'cover_image',
        'sort_order',
    ];
}
