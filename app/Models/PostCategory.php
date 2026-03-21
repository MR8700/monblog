<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostCategory extends Model
{
    use HasSlug;

    protected $fillable = ['name', 'slug', 'description', 'sort_order', 'icon'];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    /**
     * Relations
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id')
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

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Accessors
     */
    public function getPostsCountAttribute(): int
    {
        return $this->posts()->count();
    }

    public function getRouteName(): string
    {
        return route('blog.category', $this->slug);
    }
}
