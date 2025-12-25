<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
    ];

    /**
     * Get the user who borrowed the book.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the borrowed book.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Check if the borrowing is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'borrowed' && $this->due_date->isPast();
    }

    /**
     * Scope for active borrowings.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'borrowed');
    }

    /**
     * Scope for overdue borrowings.
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'borrowed')
            ->where('due_date', '<', now());
    }

    /**
     * Mark as returned.
     */
    public function markAsReturned(): void
    {
        $this->update([
            'status' => 'returned',
            'returned_at' => now(),
        ]);

        // Increment available quantity
        $this->book->increment('available_quantity');
    }
}
