<?php

namespace App\Http\Requests;

use App\Enums\PostStatus;
use App\Enums\PostVisibility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guard('admin')->check();
    }

    public function rules(): array
    {
        $postId = $this->route('post')?->id ?? 'NULL';

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                'min:5',
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('posts', 'slug')->ignore($postId),
            ],
            'excerpt' => 'nullable|string|max:500',
            'body' => [
                'required',
                'string',
                'min:20',
                'max:1000000',
            ],
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120|dimensions:min_width=400,min_height=300',
            'category_id' => 'nullable|integer|exists:post_categories,id',
            'tags' => 'nullable|array|max:10',
            'tags.*' => 'integer|exists:post_tags,id',
            'status' => [
                'nullable',
                Rule::enum(PostStatus::class),
            ],
            'visibility' => [
                'nullable',
                Rule::enum(PostVisibility::class),
            ],
            'published_at' => 'nullable|date_format:Y-m-d H:i:s',
            'scheduled_at' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:now',
            'featured' => 'nullable|boolean',
            'is_premium' => 'nullable|boolean',
            'price' => 'nullable|numeric|min:0',
            'meta_keywords' => 'nullable|string|max:160',
            'meta_description' => 'nullable|string|max:160',
            'medias' => 'nullable|array|max:20',
            'medias.*' => [
                'file',
                'max:102400',
                'mimes:jpeg,png,jpg,gif,webp,mp4,webm,pdf,doc,docx,apk,zip,rar,txt',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre de l\'article est obligatoire.',
            'title.min' => 'Le titre doit faire au moins 5 caractères.',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'slug.regex' => 'Le slug ne peut contenir que des lettres minuscules, des chiffres et des tirets.',
            'body.required' => 'Le contenu de l\'article est obligatoire.',
            'body.min' => 'L\'article doit faire au moins 20 caractères.',
            'cover_image.dimensions' => 'L\'image doit faire au moins 400x300 pixels.',
            'medias.max' => 'Vous pouvez télécharger au maximum 20 fichiers.',
            'medias.*.max' => 'Un fichier est trop volumineux (max 100 Mo).',
            'medias.*.mimes' => 'Type de fichier non autorisé.',
            'scheduled_at.after_or_equal' => 'La date de programmation doit être dans le futur.',
            'tags.max' => 'Vous pouvez ajouter au maximum 10 tags.',
        ];
    }

    /**
     * Obtenir les données validées en tant qu'enum si nécessaire
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        // Convertir les valeurs de statut et visibilité en enum si fournies
        if (isset($data['status']) && is_string($data['status'])) {
            $data['status'] = PostStatus::from($data['status']);
        }

        if (isset($data['visibility']) && is_string($data['visibility'])) {
            $data['visibility'] = PostVisibility::from($data['visibility']);
        }

        return $data;
    }

    /**
     * Préparer les données pour la validation
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'featured' => $this->boolean('featured'),
            'is_premium' => $this->boolean('is_premium'),
        ]);
    }
}
