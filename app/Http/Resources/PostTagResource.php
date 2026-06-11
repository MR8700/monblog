<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostTagResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'color' => $this->color,
            'posts_count' => $this->when($this->relationLoaded('posts'), $this->posts()->count()),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
