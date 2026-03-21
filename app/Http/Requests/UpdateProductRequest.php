<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guard('admin')->check();
    }

    public function rules(): array
    {
        $productId = $this->route('product')->id;

        return [
            'title' => 'required|string|max:255|unique:products,title,'.$productId,
            'slug' => 'nullable|string|max:255|unique:products,slug,'.$productId,
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
}
