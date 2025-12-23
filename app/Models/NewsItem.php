<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    protected $fillable = [
        'title',
        'content',
        'published_date',
        'image',
        'sort_order',
    ];
}
