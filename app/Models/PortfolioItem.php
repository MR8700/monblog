<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'admin_id',
        'title',
        'role',
        'stack',
        'summary',
        'link',
        'cover_image',
        'started_at',
        'ended_at',
        'is_current',
        'featured',
        'sort_order',
    ];

    protected $casts = [
        'started_at' => 'date',
        'ended_at' => 'date',
        'is_current' => 'boolean',
        'featured' => 'boolean',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Filtrer par recherche textuelle
     */
    public function filterSearch(Builder $query, $search): Builder
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('role', 'LIKE', "%{$search}%")
              ->orWhere('stack', 'LIKE', "%{$search}%")
              ->orWhere('summary', 'LIKE', "%{$search}%");
        });
    }
}
