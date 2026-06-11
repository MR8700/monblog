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
            'attachments.*' => 'file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,txt',
            'name' => 'nullable|string|max:255', // Nom du visiteur si pas admin
        ];
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
