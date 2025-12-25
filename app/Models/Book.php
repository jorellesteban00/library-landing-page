<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'is_featured',
        'total_quantity',
        'available_quantity',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'total_quantity' => 'integer',
        'available_quantity' => 'integer',
    ];

    /**
     * Get all borrowings for this book.
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * Get active borrowings.
     */
    public function activeBorrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class)->where('status', 'borrowed');
    }

    /**
     * Check if book is available for borrowing.
     */
    public function getIsAvailableAttribute(): bool
    {
        return $this->available_quantity > 0;
    }
}
