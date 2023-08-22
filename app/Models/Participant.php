<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = ['user_id', 'chatroom_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
