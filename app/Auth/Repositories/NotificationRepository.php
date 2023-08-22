<?php

namespace App\Auth\Repositories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;

class NotificationRepository
{
    /**
     * @param array $attributes
     *
     * @return Notification|Model
     */
    public function createModelWithAttributes(array $attributes): Notification|Model
    {
        $notification = new Notification();

        $notification->subject = $attributes['subject'];
        $notification->body = $attributes['body'];

        return $notification;
    }

    /**
     * @param array $attributes
     *
     * @return Notification|Model
     */
    public function store(array $attributes): Notification|Model
    {
        $notification = new Notification();

        $notification->subject = $attributes['subject'];
        $notification->body = $attributes['body'];

        $notification->save();

        return $notification;
    }
}