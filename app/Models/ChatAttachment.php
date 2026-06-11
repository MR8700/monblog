<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatAttachment extends Model
{
    protected $fillable = [
        'chat_message_id',
        'path',
        'original_name',
        'mime',
        'size',
    ];

    public function message()
    {
        return $this->belongsTo(ChatMessage::class, 'chat_message_id');
    }
}
