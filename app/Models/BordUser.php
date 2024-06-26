<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BordUser extends Model
{
    protected $table = "bord_user";
    protected $fillable = [
        'user_id',
        'bord_id',
    ];

    public function Users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function Bords(): HasMany
    {
        return $this->hasMany(Bord::class);
    }

}
