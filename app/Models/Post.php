<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'admin_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'published',
        'published_at',
        'views_count',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title) . '-' . time();
            }
        });
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function reactions()
    {
        return $this->hasMany(PostReaction::class);
    }

    public function views()
    {
        return $this->hasMany(PostView::class);
    }
}
