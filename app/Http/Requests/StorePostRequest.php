<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guard('admin')->check();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:posts,title',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
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
            'title.unique' => 'Ce titre existe déjà.',
            'body.required' => 'Le contenu est obligatoire.',
            'body.min' => 'Le contenu doit faire au moins 10 caractères.',
            'cover_image.image' => 'Le fichier doit être une image.',
        ];
    }
}
