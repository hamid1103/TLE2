<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class embedding extends Model
{
    protected $fillable = [
        'title',
        'chat_id',
        'file_url',
    ];

    public function ChatHistory(): BelongsTo
    {
        return $this->belongsTo('chat_histories');
    }
}
