<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'receiver_id', 'sender_id', 'message', 'sent_at', 'attachment', 'attachment_type'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'sender_id', 'receiver_id');
    }
}
