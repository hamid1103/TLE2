<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatEntry extends Model
{
    protected $fillable = [
        'Sender',
        'Content',
        'chat_history_id'
    ];

    public function ChatHistory(): BelongsTo
    {
        return $this->belongsTo(ChatHistory::class);
    }
}
