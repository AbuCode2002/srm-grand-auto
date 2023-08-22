<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Station
 *
 * @package App
 *
 * @property int                $id
 * @property string             $station_id
 * @property string             $user_id
 * @property-read  \App\Station $station
 * @property-read  \App\User    $user
 */
class StationManager extends Model
{
    protected $fillable = ['user_id', 'station_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }
}
