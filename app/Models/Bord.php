<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bord extends Model
{
    protected $fillable = [
        'Title'
    ];

    public function ChatEntries(): BelongsToMany
    {
        return $this->belongsToMany(ChatEntry::class, 'bord_chatentries');
    }

}
