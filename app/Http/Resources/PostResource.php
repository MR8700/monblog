<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'body' => $this->body,
            'cover_image' => $this->cover_image,
            'status' => $this->status?->value,
            'status_label' => $this->status?->label(),
            'visibility' => $this->visibility?->value,
            'visibility_label' => $this->visibility?->label(),
            'featured' => $this->featured,
            'reading_time' => $this->reading_time,
            'views_count' => $this->views_count,
            'published_at' => $this->published_at?->toIso8601String(),
            'scheduled_at' => $this->scheduled_at?->toIso8601String(),
            'archived_at' => $this->archived_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'meta_keywords' => $this->meta_keywords,
            'meta_description' => $this->meta_description,
            
            // Relations
            'author' => AdminResource::make($this->whenLoaded('admin')),
            'category' => PostCategoryResource::make($this->whenLoaded('category')),
            'tags' => PostTagResource::collection($this->whenLoaded('tags')),
            'medias' => PostMediaResource::collection($this->whenLoaded('medias')),
            'comments_count' => $this->when($this->relationLoaded('comments'), $this->comments()->count()),
            'reactions_count' => $this->when($this->relationLoaded('reactions'), $this->reactions()->count()),
        ];
    }
}
