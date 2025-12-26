<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_description',
        'featured_image',
        'is_published',
        'publish_at',
        'sort_order',
        'parent_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'publish_at' => 'datetime',
        'sort_order' => 'integer',
    ];

    /**
     * Get the parent page.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    /**
     * Get child pages.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Get visible child pages (published and not scheduled for future).
     */
    public function visibleChildren(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id')
            ->where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('publish_at')
                    ->orWhere('publish_at', '<=', Carbon::now());
            })
            ->orderBy('sort_order');
    }

    /**
     * Scope for top-level pages (no parent).
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for published pages.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('publish_at')
                    ->orWhere('publish_at', '<=', Carbon::now());
            });
    }

    /**
     * Scope for scheduled (future) pages.
     */
    public function scopeScheduled($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('publish_at')
            ->where('publish_at', '>', Carbon::now());
    }

    /**
     * Scope for draft pages.
     */
    public function scopeDraft($query)
    {
        return $query->where('is_published', false);
    }

    /**
     * Check if page is currently published (live).
     */
    public function isLive(): bool
    {
        if (!$this->is_published) {
            return false;
        }

        if ($this->publish_at && $this->publish_at->isFuture()) {
            return false;
        }

        return true;
    }

    /**
     * Check if page is scheduled for future publishing.
     */
    public function isScheduled(): bool
    {
        return $this->is_published
            && $this->publish_at
            && $this->publish_at->isFuture();
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute(): string
    {
        if (!$this->is_published) {
            return 'Draft';
        }

        if ($this->isScheduled()) {
            return 'Scheduled';
        }

        return 'Published';
    }

    /**
     * Get the status color for UI.
     */
    public function getStatusColorAttribute(): string
    {
        if (!$this->is_published) {
            return 'gray';
        }

        if ($this->isScheduled()) {
            return 'blue';
        }

        return 'green';
    }

    /**
     * Get breadcrumb trail.
     */
    public function getBreadcrumbs(): array
    {
        $breadcrumbs = [];
        $page = $this;

        while ($page) {
            array_unshift($breadcrumbs, $page);
            $page = $page->parent;
        }

        return $breadcrumbs;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
