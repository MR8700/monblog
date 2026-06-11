<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guard('admin')->check();
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id ?? null;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:3',
                Rule::unique('post_categories', 'name')->ignore($categoryId),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('post_categories', 'slug')->ignore($categoryId),
            ],
            'description' => 'nullable|string|max:1000',
            'icon' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^fa-[a-z0-9-]+$/', // Validation d'icône Font Awesome
            ],
            'sort_order' => 'nullable|integer|min:0|max:9999',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de la catégorie est obligatoire.',
            'name.min' => 'Le nom doit faire au moins 3 caractères.',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'name.unique' => 'Cette catégorie existe déjà.',
            'slug.regex' => 'Le slug ne peut contenir que des lettres minuscules, des chiffres et des tirets.',
            'slug.unique' => 'Ce slug est déjà utilisé.',
            'icon.regex' => 'L\'icône doit être une classe Font Awesome valide (ex: fa-newspaper).',
            'sort_order.integer' => 'L\'ordre de tri doit être un nombre entier.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'sort_order' => $this->integer('sort_order') ?? 0,
        ]);
    }
}
