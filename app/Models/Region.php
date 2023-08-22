<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Region
 *
 * @property int                                                         $id
 * @property string                                                      $region_name
 * @property int                                                         $parent_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Region[] $children
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
}
