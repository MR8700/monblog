<?php
namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, Filterable;

    const TYPE_WORK = 'work';
    const TYPE_APP = 'app';
    const TYPE_TASK = 'task';
    const TYPE_SERVICE = 'service';

    protected $fillable = [
        'title',
        'description',
        'slug',
        'type',
        'image',
        'file_path',
        'is_downloadable',
        'price',
        'whatsapp',
        'facebook',
        'phone',
        'email',
        'published',
    ];

    protected $casts = [
        'is_downloadable' => 'boolean',
        'published' => 'boolean',
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

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Filtrer par recherche textuelle (Surcharge)
     */
    public function filterSearch(Builder $query, $search): Builder
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhere('type', 'LIKE', "%{$search}%");
        });
    }

    public function filterType(Builder $query, $type): Builder
    {
        return $query->where('type', $type);
    }

    public function filterPublished(Builder $query, $published): Builder
    {
        return $query->where('published', $published === 'yes' ? 1 : 0);
    }
}
