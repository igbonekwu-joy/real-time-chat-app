<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageClear extends Model
{
    protected $fillable = [
        'user_id',
        'friend_id',
        'cleared_at'
    ];
}
