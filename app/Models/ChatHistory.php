<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatHistory extends Model
{
    protected $fillable = [
        'ChatTitle',
    ];

    public function ChatEntry(): HasMany
    {
        return $this->hasMany(ChatEntry::class);
    }
}
