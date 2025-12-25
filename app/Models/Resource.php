<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resource extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'url',
        'file_path',
        'is_published',
        'sort_order',
        'created_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the user who created this resource.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope for published resources.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for ordering by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Get the resource URL (either external URL or file storage URL).
     */
    public function getResourceUrlAttribute(): ?string
    {
        if ($this->url) {
            return $this->url;
        }

        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }

        return null;
    }
}
