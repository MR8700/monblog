<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Post;

class PostPolicy
{
    /**
     * Déterminer si l'utilisateur peut voir le modèle.
     */
    public function view(?Admin $user, Post $post): bool
    {
        // Les articles publics visibles par tous
        if ($post->status->value === 'published' && $post->visibility->value === 'public') {
            return true;
        }

        // Les administrateurs peuvent voir tous les articles
        return $user?->id === $post->admin_id || $user?->hasRole('super_admin');
    }

    /**
     * Déterminer si l'utilisateur peut créer un modèle.
     */
    public function create(Admin $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('super_admin');
    }

    /**
     * Déterminer si l'utilisateur peut mettre à jour le modèle.
     */
    public function update(Admin $user, Post $post): bool
    {
        return $user->id === $post->admin_id || $user->hasRole('super_admin');
    }

    /**
     * Déterminer si l'utilisateur peut supprimer le modèle.
     */
    public function delete(Admin $user, Post $post): bool
    {
        return $user->id === $post->admin_id || $user->hasRole('super_admin');
    }

    /**
     * Déterminer si l'utilisateur peut restaurer le modèle.
     */
    public function restore(Admin $user, Post $post): bool
    {
        return $user->id === $post->admin_id || $user->hasRole('super_admin');
    }

    /**
     * Déterminer si l'utilisateur peut supprimer définitivement le modèle.
     */
    public function forceDelete(Admin $user, Post $post): bool
    {
        return $user->hasRole('super_admin');
    }
}
