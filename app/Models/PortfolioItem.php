<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    protected $fillable = [
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
}
