<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'icon' => $this->icon,
            'sort_order' => $this->sort_order,
            'posts_count' => $this->when($this->relationLoaded('posts'), $this->posts()->count()),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
