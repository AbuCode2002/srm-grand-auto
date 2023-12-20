<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Car
 *
 * @property int                $id
 * @property int                $company_id
 * @property int                $contract_id
 * @property string             number
 * @property string             $vin_number
 * @property string             $brand
 * @property string             $model
 * @property integer            $year
 * @property-read \App\Models\Company  $company
 * @property-read \App\Models\Contract $contract
 */
class Car extends Model
{
    use  SoftDeletes;

    static protected $columns = [
        'number'             => ['ork'],
        'brand'              => ['ork'],
        'model'              => ['ork'],
        'year'               => ['ork'],
        'company_id'         => ['ork'],
        'type'               => ['ork'],
        'number_of_contract' => ['ork'],
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'number',
        'brand',
        'model',
        'vin_number',
        'company_id',
        'year',
        'type',
        'company',
        'contract_id',
        'is_broken',
        'service_type',
        'driver_type',
        'mileage',
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
        'number' => 'string',
        'brand'  => 'string',
        'model'  => 'string',
        'year'   => 'integer',
//        'type' => 'string',
        // 'created_at' => 'timestamp',
        // 'updated_at' => 'timestamp'
    ];

    /**
     * Get the Orders for the Car.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    /**
     * Get the Company for the Car.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
