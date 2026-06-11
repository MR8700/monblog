<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait pour filtrer les modèles avec des paramètres de query
 */
trait Filterable
{
    /**
     * Appliquer les filtres au modèle
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        foreach ($filters as $key => $value) {
            if (empty($value)) {
                continue;
            }

            $method = 'filter' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

            if (method_exists($this, $method)) {
                $this->$method($query, $value);
            }
        }

        return $query;
    }

    /**
     * Filtrer par statut
     */
    public function filterStatus(Builder $query, $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Filtrer par visibilité
     */
    public function filterVisibility(Builder $query, $visibility): Builder
    {
        return $query->where('visibility', $visibility);
    }

    /**
     * Filtrer par recherche textuelle
     */
    public function filterSearch(Builder $query, $search): Builder
    {
        return $query->where('title', 'LIKE', "%{$search}%")
            ->orWhere('excerpt', 'LIKE', "%{$search}%")
            ->orWhere('body', 'LIKE', "%{$search}%");
    }

    /**
     * Filtrer par catégorie
     */
    public function filterCategory(Builder $query, $category): Builder
    {
        return $query->where('category_id', $category);
    }

    /**
     * Filtrer par date
     */
    public function filterDateFrom(Builder $query, $date): Builder
    {
        return $query->whereDate('published_at', '>=', $date);
    }

    public function filterDateTo(Builder $query, $date): Builder
    {
        return $query->whereDate('published_at', '<=', $date);
    }
}
