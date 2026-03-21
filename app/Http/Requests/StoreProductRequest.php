<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guard('admin')->check();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:products,title',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string|min:10',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'whatsapp' => 'nullable|string|max:20',
            'facebook' => 'nullable|url',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'published' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'price.numeric' => 'Le prix doit être un nombre.',
            'facebook.url' => 'Veuillez entrer une URL valide pour Facebook.',
        ];
    }
}
