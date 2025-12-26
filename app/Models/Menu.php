<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'url',
        'link_type',
        'description',
        'target',
        'is_visible',
        'icon',
        'order',
        'parent_id',
    ];
    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    public function visibleChildren()
    {
        return $this->hasMany(Menu::class, 'parent_id')->where('is_visible', true)->orderBy('order');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    public function isExternal(): bool
    {
        return $this->link_type === 'external';
    }
}
