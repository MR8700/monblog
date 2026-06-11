<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guard('admin')->check();
    }

    public function rules(): array
    {
        $tagId = $this->route('tag')?->id ?? null;

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                'min:2',
                Rule::unique('post_tags', 'name')->ignore($tagId),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('post_tags', 'slug')->ignore($tagId),
            ],
            'color' => [
                'nullable',
                'string',
                'max:7',
                'regex:/^#[0-9a-fA-F]{6}$/', // Validation de couleur hexadécimale
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom du tag est obligatoire.',
            'name.min' => 'Le nom doit faire au moins 2 caractères.',
            'name.unique' => 'Ce tag existe déjà.',
            'slug.regex' => 'Le slug ne peut contenir que des lettres minuscules, des chiffres et des tirets.',
            'color.regex' => 'La couleur doit être un code hexadécimal valide (ex: #0066cc).',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Normaliser la couleur
        if ($this->has('color') && $this->color) {
            $color = $this->color;
            if (strlen($color) === 6) {
                $color = '#' . $color;
            }
            $this->merge(['color' => $color]);
        }
    }
}
