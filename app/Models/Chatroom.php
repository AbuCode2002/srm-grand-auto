<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Chatroom
 *
 * @property int     $id
 * @property integer $order_id
 */
class Chatroom extends Model
{
    protected $fillable = ['order_id'];

    public function messages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function participants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function addParticipant($userId): Chatroom
    {
        Participant
            ::query()
            ->create(
                [
                    'user_id'     => $userId,
                    'chatroom_id' => $this->id,
                ]
            )
        ;

        return $this;
    }

    public function removeParticipant($userId): Chatroom
    {
        Participant
            ::query()
            ->where('user_id', $userId)
            ->where('chatroom_id', $this->id)
            ->delete()
        ;

        return $this;
    }
}
