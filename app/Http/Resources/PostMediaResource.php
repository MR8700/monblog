<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostMediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'filename' => $this->filename,
            'original_name' => $this->original_name,
            'type' => $this->type,
            'mime_type' => $this->mime_type,
            'size' => $this->size,
            'size_formatted' => $this->sizeFormatted(),
            'path' => asset('storage/' . $this->path),
            'description' => $this->description,
            'display_order' => $this->display_order,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
