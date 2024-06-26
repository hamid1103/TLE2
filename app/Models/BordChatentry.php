<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BordChatentry extends Pivot
{
    protected $table = "bord_chatentries";
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
