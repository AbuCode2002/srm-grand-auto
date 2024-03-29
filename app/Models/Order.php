<?php

namespace App\Models;

use App\Events\StatusChanged;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Order
 *
 * @property integer id,
 * @property integer car_id,
 * @property integer region_id,
 * @property $is_evacuated,
 * @property $location,
 * @property $contract_id,
 * @property $problem_description,
 * @property $is_broken,
 * @property $service_type,
 * @property $driver_id,
 * @property $driver_type,
 * @property $mileage,
 * @property $kpi1,
 * @property $kpi2,
 * @property $kpi3,
 * @property-read \App\Models\Region    $region
 * @property-read \App\Models\Client    $client
 * @property-read \App\Models\Car       $car
 * @property-read \App\Models\Station   $station
 * @property-read \App\Models\Contract  $contract
 */
class Order extends Model
{
    use  SoftDeletes;

    static protected $columns = [
        'id'                        => ['*'],
        'problem_description'       => ['ork', 'client_id', 'guest', 'orpu', 'orpa', 'station'],
        'client_name'               => ['ork', 'orpu', 'orpa', 'op', 'accountant'],
        'number'                    => ['*'],
        'car_model'                 => ['*'],
        'status'                    => ['*'],
        'region_id'                 => ['ork', 'orpu', 'orpa', 'op', 'client', 'guest', 'accountant'],
        'defect_acts'               => ['*'],
        'sum_defect_without_markup' => ['ork', 'orpu', 'orpa'],
        'sum_defect'                => ['ork', 'client', 'guest', 'orpu', 'orpa'],
        'service_type'              => ['client', 'guest', 'station', 'ork', 'orpu'],
        'driver_type'               => ['client', 'guest', 'station', 'ork', 'orpu'],
        'mileage'                   => ['client', 'guest', 'station', 'ork', 'orpu'],
        'is_broken'                 => ['client', 'guest', 'station', 'ork', 'orpu'],
        'paid'                      => ['ork', 'orpu', 'orpa'],
        'created_at'                => ['client', 'guest', 'station', 'ork', 'orpu'],
        'ready_to_diagnose_at'      => ['client', 'guest', 'station', 'ork', 'orpu'],
        'ready_to_repair_at'        => ['client', 'guest', 'station', 'ork', 'orpu'],
        'planned_to_completed_at'   => ['client', 'guest', 'station', 'ork', 'orpu'],
        'is_evacuated'              => ['ork', 'client', 'guest', 'orpu'],
        'evacuator_name'            => ['ork', 'orpu', 'op', 'accountant'],
        'station_name'              => ['orpu', 'ork', 'orpa', 'op', 'accountant'],
        'station_phone'             => ['client'],
        'address'                   => ['ork', 'client', 'guest', 'orpu'],
        'number_of_contract'        => ['ork', 'client', 'guest', 'op', 'accountant'],
        'defect_sum'                => ['client'],
        'signed_at'                 => ['ork', 'client', 'guest', 'op', 'accountant'],
        'expire_at'                 => ['ork', 'client', 'guest', 'op', 'accountant'],
        'completed_at'              => ['client', 'guest', 'station', 'ork', 'orpu'],
        'downtime'                  => ['station'],
        'car_brand'                 => ['*'],
        'car_year'                  => ['*'],
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'car_id',
        'is_evacuated',
        'region_id',
        'driver_id',
        'problem_description',
        'status',
        'status_internal',
        'ready_to_repair_at',
        'contract_id',
        'station_id',
        'completed_at',
        'evacuator_id',
        'ork_id',
        'orpu_id',
        'orpa_id',
        'shop_id',
        'is_broken',
        'service_type',
        'driver_type',
        'mileage',
        'ready_to_diagnose_at',
        'diagnosed_at',
        'reconsidered_at',
        'planned_to_completed_at',
        'orpa',
        'paid_at',
        'telegram_thread_id',
        'telegram_chat_id',
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
        'is_evacuated'        => 'boolean',
        'region_id'           => 'string',
        'problem_description' => 'string',
        'status'              => 'string',
        'status_internal'     => 'integer',
    ];

    public function defectiveActs(): HasOne
    {
        return $this->hasOne(DefectiveAct::class);
    }

    /**
     * Get the Driver for the Order.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }


    /**
     * Get the Car for the Order.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status', 'id');
    }

    /**
     * Get the Station for the Order.
     */
    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_order');
    }
}
