<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChatMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public chat
    }

    public function rules(): array
    {
        return [
            'body' => 'nullable|string|max:3000',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|max:5120|mimes:pdf,jpg,jpeg,png,webp,txt',
            'name' => 'nullable|string|max:120',
            'room' => 'nullable|string|max:120',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => $this->filled('name') ? strip_tags($this->input('name')) : null,
        ]);
    }

    public function messages(): array
    {
        return [
            'body.max' => 'Le message ne doit pas dépasser 3000 caractères.',
            'attachments.*.max' => 'Le fichier joint est trop volumineux (max 10 Mo).',
            'attachments.max' => 'Vous pouvez ajouter au maximum 5 fichiers.',
        ];
    }
}
