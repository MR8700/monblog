<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public ordering
    }

    public function rules(): array
    {
        return [
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email',
            'user_phone' => 'required|string|min:7|max:20',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'user_name.required' => 'Le nom est obligatoire.',
            'user_email.required' => 'L\'email est obligatoire.',
            'user_email.email' => 'Veuillez entrer une adresse email valide.',
            'user_phone.required' => 'Le téléphone est obligatoire.',
            'products.required' => 'Veuillez sélectionner au moins un produit.',
        ];
    }
}
