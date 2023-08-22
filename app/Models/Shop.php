<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use  ReturnsColumnsByRole, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'region_id', 'address', 'dir_name', 'dir_phone', 'specialist_name', 'specialist_phone', 'jur_address', 'fact_address', 'bin', 'bik', 'iik', 'bank', 'bank_id', 'region', 'contact_person', 'contact_phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    protected $table = 'shops';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name'             => 'string',
        'city'             => 'string',
        'address'          => 'string',
        'dir_name'         => 'string',
        'dir_phone'        => 'string',
        'specialist_name'  => 'string',
        'specialist_phone' => 'string',
        'jur_address'      => 'string',
        'bin'              => 'string',
        'bik'              => 'string',
        'iik'              => 'string',
        'contact_person'   => 'string',
        'contact_phone'    => 'string',
        'created_at'       => 'timestamp',
        'updated_at'       => 'timestamp',
    ];

    /**
     * Get the CarTypes for the Shop.
     */
    protected $columns = [];

    public function carTypes()
    {
        return $this->belongsToMany(CarType::class);
    }
}
