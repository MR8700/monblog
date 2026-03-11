<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostReaction extends Model
{
    protected $fillable = [
        'post_id',
        'type',
        'visitor_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
