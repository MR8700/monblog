<?php

namespace App\Models;

use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostMedia extends Model
{
    use HasMedia;

    protected $table = 'post_medias';
    protected $fillable = [
        'post_id',
        'path',
        'original_name',
        'filename',
        'mime_type',
        'size',
        'type',
        'description',
        'display_order',
    ];

    protected $casts = [
        'size' => 'integer',
        'display_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Scopes
     */
    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }

    public function scopeDocuments($query)
    {
        return $query->where('type', 'document');
    }

    public function scopeApks($query)
    {
        return $query->where('type', 'apk');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    /**
     * Retourne le type de média basé sur MIME
     */
    public static function getTypeFromMime(string $mime): string
    {
        return match(true) {
            str_contains($mime, 'image') => 'image',
            str_contains($mime, 'video') => 'video',
            str_contains($mime, 'pdf') => 'document',
            str_contains($mime, 'word') || str_contains($mime, 'document') => 'document',
            str_contains($mime, 'android') || str_ends_with($mime, 'apk') => 'apk',
            str_contains($mime, 'audio') => 'audio',
            default => 'file',
        };
    }

    /**
     * Accessors
     */
    public function getUrlAttribute(): string
    {
        return $this->getFileUrl($this->path);
    }

    public function getIsImageAttribute(): bool
    {
        return $this->type === 'image';
    }

    public function getIsVideoAttribute(): bool
    {
        return $this->type === 'video';
    }

    public function getIsDocumentAttribute(): bool
    {
        return $this->type === 'document';
    }

    public function getIsApkAttribute(): bool
    {
        return $this->type === 'apk';
    }

    public function getIcon(): string
    {
        return match($this->type) {
            'image' => 'fa-image',
            'video' => 'fa-video',
            'document' => 'fa-file-pdf',
            'apk' => 'fa-mobile',
            'audio' => 'fa-music',
            default => 'fa-file',
        };
    }

    /**
     * Delete event - supprimer le fichier when the model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($media) {
            $media->deleteFile($media->path);
        });
    }
}
