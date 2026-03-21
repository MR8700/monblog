<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\PortfolioItem;

class PortfolioItemPolicy
{
    /**
     * Admin peut voir tous les éléments du portfolio
     */
    public function viewAny(Admin $admin): bool
    {
        return true;
    }

    /**
     * Admin peut voir un élément spécifique
     */
    public function view(Admin $admin, PortfolioItem $item): bool
    {
        return true;
    }

    /**
     * Admin peut créer un élément
     */
    public function create(Admin $admin): bool
    {
        return true;
    }

    /**
     * Admin peut modifier un élément s'il l'a créé ou est super_admin
     */
    public function update(Admin $admin, PortfolioItem $item): bool
    {
        return $admin->id === $item->admin_id || $admin->is_super_admin;
    }

    /**
     * Admin peut supprimer un élément s'il l'a créé ou est super_admin
     */
    public function delete(Admin $admin, PortfolioItem $item): bool
    {
        return $admin->id === $item->admin_id || $admin->is_super_admin;
    }

    /**
     * Admin peut restaurer un élément (soft deletes)
     */
    public function restore(Admin $admin, PortfolioItem $item): bool
    {
        return $admin->is_super_admin;
    }

    /**
     * Admin peut forcer la suppression
     */
    public function forceDelete(Admin $admin, PortfolioItem $item): bool
    {
        return $admin->is_super_admin;
    }
}
