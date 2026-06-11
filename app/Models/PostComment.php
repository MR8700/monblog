<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $fillable = [
        'post_id',
        'name',
        'email',
        'body',
        'is_admin',
        'approved',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'approved' => 'boolean',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
