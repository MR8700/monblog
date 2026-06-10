<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_id',
        'author_name',
        'content',
        'is_admin',
    ];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }
}
