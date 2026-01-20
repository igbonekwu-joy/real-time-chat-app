<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    protected $fillable = [
        'group_id',
        'user_id',
        'is_admin',
    ];
}
