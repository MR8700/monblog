<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory, Filterable;

    const STATUS_UNPAID = 'unpaid';
    const STATUS_PAID = 'paid';
    const STATUS_FAILED = 'failed';
    const STATUS_PENDING = 'pending';

    protected $fillable = [
        'admin_id',
        'public_token',
        'user_email',
        'user_phone',
        'user_name',
        'status',
        'total_price',
        'payment_method',
        'payment_status',
        'payment_processed_at',
        'payment_reference',
        'ligdicash_token_hash',
        'payment_otp',
        'notes',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'payment_processed_at' => 'datetime',
    ];

    protected $hidden = [
        'ligdicash_token_hash',
        'payment_otp',
    ];

    protected static function booted(): void
    {
        static::creating(function (Order $order): void {
            if (empty($order->public_token)) {
                $order->public_token = Str::random(48);
            }
        });
    }

    public function publicRouteParameter(): string
    {
        return $this->public_token ?: (string) $this->getKey();
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

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
            $q->where('user_name', 'LIKE', "%{$search}%")
              ->orWhere('user_email', 'LIKE', "%{$search}%")
              ->orWhere('payment_reference', 'LIKE', "%{$search}%");
        });
    }

    public function filterPaymentStatus(Builder $query, $status): Builder
    {
        return $query->where('payment_status', $status);
    }
}
