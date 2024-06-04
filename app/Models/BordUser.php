<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BordUser extends Model
{
    protected $fillable = [
        'user_id',
        'bord_id',
    ];
}
