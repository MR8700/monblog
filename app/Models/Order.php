<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'admin_id',
        'user_email',
        'user_phone',
        'user_name',
        'status',
        'total_price',
        'notes',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
