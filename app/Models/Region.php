<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Region
 *
 * @property int                                                         $id
 * @property string                                                      $region_name
 * @property int                                                         $parent_id
 * @property int                                                         $budget
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $children
 */
class Region extends Model
{
    protected $fillable = [
        'id', 'region_name',
    ];

    protected $table = 'regions';

    public function children()
    {
        return $this->hasMany(Region::class, 'parent_id');
    }


    /**
     * @return HasMany
     */
    public function user(): HasMany
    {
        return $this->hasMany(UserToRegion::class);
    }
    public function station(): HasMany
    {
        return $this->hasMany(Station::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function regions()
    {
        return $this->hasMany(Region::class, 'id', 'id');

    }
}
