<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Enums\PostVisibility;
use App\Traits\Filterable;
use App\Traits\HasReadingTime;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasSlug, HasReadingTime, Filterable, HasFactory;

    protected $fillable = [
        'admin_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'status',
        'visibility',
        'published_at',
        'scheduled_at',
        'archived_at',
        'views_count',
        'reading_time',
        'price',
        'is_premium',
        'featured',
        'meta_keywords',
        'meta_description',
    ];

    protected $casts = [
        'status' => PostStatus::class,
        'visibility' => PostVisibility::class,
        'featured' => 'boolean',
        'is_premium' => 'boolean',
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'archived_at' => 'datetime',
        'views_count' => 'integer',
        'reading_time' => 'integer',
    ];

    protected function getSlugSourceColumn(): string
    {
        return 'title';
    }

    /**
     * Relations
     */
    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(PostReaction::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(PostView::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(PostTag::class, 'post_tag_pivot', 'post_id', 'post_tag_id');
    }

    public function medias(): HasMany
    {
        return $this->hasMany(PostMedia::class)->orderBy('display_order');
    }

    /**
     * Scopes
     */
    public function scopePublished($query)
    {
        return $query->where('status', PostStatus::PUBLISHED)
            ->where('visibility', PostVisibility::PUBLIC);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', PostStatus::DRAFT);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', PostStatus::SCHEDULED)
            ->where('scheduled_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true)->published();
    }

    public function scopeLatest($query)
    {
        return $query->orderByDesc('published_at');
    }

    public function scopeWithRelations($query)
    {
        return $query->with(['admin', 'category', 'tags', 'medias'])
            ->withCount(['comments', 'reactions', 'views']);
    }

    /**
     * Accessors
     */
    public function getIsPublishedAttribute(): bool
    {
        return $this->status === PostStatus::PUBLISHED && 
               $this->visibility === PostVisibility::PUBLIC;
    }

    public function getIsViewableAttribute(): bool
    {
        return $this->is_published || auth('admin')?->user()?->id === $this->admin_id;
    }

    public function getReadingTimeFormattedAttribute(): string
    {
        return $this->getReadingTimeFormatted();
    }
}
