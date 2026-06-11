<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Product;

class ProductPolicy
{
    /**
     * Admin peut voir tous les produits
     */
    public function viewAny(Admin $admin): bool
    {
        return true;
    }

    /**
     * Admin peut voir un produit spécifique
     */
    public function view(Admin $admin, Product $product): bool
    {
        return true;
    }

    /**
     * Admin peut créer un produit
     */
    public function create(Admin $admin): bool
    {
        return true;
    }

    /**
     * Admin peut modifier un produit s'il l'a créé ou est super_admin
     */
    public function update(Admin $admin, Product $product): bool
    {
        return $admin->id === $product->admin_id || $admin->is_super_admin;
    }

    /**
     * Admin peut supprimer un produit s'il l'a créé ou est super_admin
     */
    public function delete(Admin $admin, Product $product): bool
    {
        return $admin->id === $product->admin_id || $admin->is_super_admin;
    }

    /**
     * Admin peut restaurer un produit (soft deletes)
     */
    public function restore(Admin $admin, Product $product): bool
    {
        return $admin->is_super_admin;
    }

    /**
     * Admin peut forcer la suppression d'un produit
     */
    public function forceDelete(Admin $admin, Product $product): bool
    {
        return $admin->is_super_admin;
    }
}
