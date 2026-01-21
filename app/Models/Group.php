<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'image',
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'group_users')
                ->withPivot('is_admin');
    }

    public function messages() {
        return $this->hasMany(GroupMessage::class);
    }
}
