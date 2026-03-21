<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PostTag extends Model
{
    use HasSlug;

    protected $table = 'post_tags';
    protected $fillable = ['name', 'slug', 'color'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tag_pivot', 'post_tag_id', 'post_id')
            ->where('status', 'published')
            ->where('visibility', 'public')
            ->latest('published_at');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->whereHas('posts', function ($q) {
            $q->where('status', 'published')
                ->where('visibility', 'public');
        });
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->withCount('posts')
            ->orderByDesc('posts_count')
            ->limit($limit);
    }

    /**
     * Accessors
     */
    public function getPostsCountAttribute(): int
    {
        return $this->posts()->count();
    }

    public function getColorAttribute($value): string
    {
        return $value ?? '#0066cc';
    }

    public function getRouteName(): string
    {
        return route('blog.tag', $this->slug);
    }
}
