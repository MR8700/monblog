<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_request_id',
        'title',
        'description',
        'file_path',
        'preview_path',
        'price',
        'status',
        'secure_token',
        'is_public',
        'reactions',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_public' => 'boolean',
        'reactions' => 'array',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($delivery) {
            $delivery->secure_token = $delivery->secure_token ?? (string) Str::uuid();
        });
    }

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function comments()
    {
        return $this->hasMany(DeliveryComment::class);
    }
}
