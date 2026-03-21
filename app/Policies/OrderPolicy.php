<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Order;

class OrderPolicy
{
    /**
     * Admin peut voir toutes les commandes
     */
    public function viewAny(Admin $admin): bool
    {
        return true;
    }

    /**
     * Admin peut voir les détails d'une commande
     */
    public function view(Admin $admin, Order $order): bool
    {
        return true;
    }

    /**
     * Les commandes sont créées par les utilisateurs publics, pas par les admins
     */
    public function create(Admin $admin): bool
    {
        return false;
    }

    /**
     * Admin peut mettre à jour le statut d'une commande
     */
    public function update(Admin $admin, Order $order): bool
    {
        return true;
    }

    /**
     * Admin peut annuler une commande
     */
    public function delete(Admin $admin, Order $order): bool
    {
        return true;
    }

    /**
     * Seul le super_admin peut restaurer une commande (soft deletes)
     */
    public function restore(Admin $admin, Order $order): bool
    {
        return $admin->is_super_admin;
    }

    /**
     * Seul le super_admin peut forcer la suppression
     */
    public function forceDelete(Admin $admin, Order $order): bool
    {
        return $admin->is_super_admin;
    }
}
