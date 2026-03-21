<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guard('admin')->check();
    }

    public function rules(): array
    {
        $postId = $this->route('post')->id;

        return [
            'title' => 'required|string|max:255|unique:posts,title,'.$postId,
            'slug' => 'nullable|string|max:255|unique:posts,slug,'.$postId,
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string|min:10',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'body.required' => 'Le contenu est obligatoire.',
        ];
    }
}
