<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'room',
        'author_name',
        'author_type',
        'body',
    ];

    public function attachments()
    {
        return $this->hasMany(ChatAttachment::class);
    }
}
