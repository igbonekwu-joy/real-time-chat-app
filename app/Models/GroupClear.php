<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupClear extends Model
{
    protected $fillable = [
        'group_id',
        'user_id',
        'cleared_at'
    ];
}
