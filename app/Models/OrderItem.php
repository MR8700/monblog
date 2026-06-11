<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'post_id', 'quantity', 'price'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
