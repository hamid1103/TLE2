<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    public $timestamps = false;
    protected $table = 'user_settings';
    protected $fillable = [
        'user_id',
        'hideNSFW'
    ];
}
