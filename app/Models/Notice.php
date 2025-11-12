<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Notice extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'category',
        'is_important',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_important' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'category' => $this->category,
            'is_published' => $this->is_published,
            'published_at' => $this->published_at?->toIso8601String(),
        ];
    }

    public function shouldBeSearchable()
    {
        return $this->is_published && $this->published_at && $this->published_at <= now();
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now());
    }

    public function scopeImportant($query)
    {
        return $query->where('is_important', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
