<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'slug',
        'image',
        'price',
        'whatsapp',
        'facebook',
        'phone',
        'email',
        'published',
    ];

    // Générer automatiquement le slug si non fourni
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title) . '-' . time();
            }
        });
    }
}
