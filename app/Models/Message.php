<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id',
        'chatroom_id',
        'message',
        'type',
        'status_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
