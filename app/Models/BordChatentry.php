<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BordChatentry extends Model
{
    protected $fillable = [
        'chat_entry_id',
        'bord_id',
    ];

    public function Boards(): HasMany
    {
        return $this->hasMany(Bord::class);
    }

    public function chatEntries(): HasMany
    {
        return $this->hasMany(ChatEntry::class);
    }
}
