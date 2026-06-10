<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'client_name',
        'client_email',
        'client_phone',
        'service_type',
        'description',
        'custom_fields',
        'price',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'custom_fields' => 'array',
        'price' => 'decimal:2',
    ];

    public function attachments()
    {
        return $this->hasMany(ServiceRequestAttachment::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    public function interactions()
    {
        return $this->hasMany(ServiceRequestInteraction::class)->latest();
    }

    /**
     * Filtrer par recherche textuelle
     */
    public function filterSearch(Builder $query, $search): Builder
    {
        return $query->where(function($q) use ($search) {
            $q->where('client_name', 'LIKE', "%{$search}%")
              ->orWhere('client_email', 'LIKE', "%{$search}%")
              ->orWhere('service_type', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%");
        });
    }

    public function filterType(Builder $query, $type): Builder
    {
        return $query->where('service_type', $type);
    }
}
