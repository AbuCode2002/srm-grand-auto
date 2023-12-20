<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Station
 *
 * @property int              $id
 * @property string           $name
 * @property integer          $region_id
 * @property string           fact_address
 * @property string           jur_address
 * @property-read \App\Models\Region $region
 */
class Station extends Model
{
    use  SoftDeletes;

    static protected $columns = [
        'id'             => ['orpu'],
        'name'           => ['orpu'],
        'region'         => ['orpu'],
        'address'        => ['orpu'],
        'jur_address'    => ['orpu'],
        'bin'            => ['orpu'],
        'bik'            => ['orpu'],
        'iik'            => ['orpu'],
        'contact_person' => ['orpu'],
        'contact_phone'  => ['orpu'],
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'region_id', 'region', 'address', 'fact_address', 'jur_address', 'bin', 'bik', 'iik', 'bank', 'contact_person', 'contact_phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name'           => 'string',
        'region_id'      => 'integer',
        'address'        => 'string',
        'jur_address'    => 'string',
        'bin'            => 'string',
        'bik'            => 'string',
        'iik'            => 'string',
        'contact_person' => 'string',
        'contact_phone'  => 'string',
        'created_at'     => 'timestamp',
        'updated_at'     => 'timestamp',
    ];

    /**
     * Get the Orders for the Station.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }


    /**
     * Get the CarTypes for the Station.
     */
    public function carTypes()
    {
        return $this->belongsToMany(CarType::class);
    }

    /**
     * Get the Region for the Station.
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
