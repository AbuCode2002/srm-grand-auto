<?php

namespace App\Models;

use App\Events\StatusChanged;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Order
 *
 * @property integer car_id,
 * @property integer client_id,
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
 * @property-read \App\Models\Region    $region
 * @property-read \App\Models\Client    $client
 * @property-read \App\Models\Chatroom  $chatroom
 * @property-read \App\Models\Car       $car
 * @property-read \App\Models\Station   $station
 * @property-read \App\Models\Contract  $contract
 * @property-read \App\Models\DefectAct $defectActs
 */
class Order extends Model
{
    use  SoftDeletes;

    static protected $columns = [
        'id'                        => ['*'],
        'problem_description'       => ['ork', 'client', 'guest', 'orpu', 'orpa', 'station'],
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
        'client_id',
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
        // 'signed_at' => 'timestamp',
        // 'expire_at' => 'timestamp',
        // 'ready_to_diagnose_at' => 'timestamp',
        // 'ready_to_repair_at' => 'timestamp',
        // 'created_at' => 'timestamp',
        // 'updated_at' => 'timestamp',
    ];

    /**
     * Get the DefectActs for the Order.
     */
    public function defectActs(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(DefectAct::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Get the Comments for the Order.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    /**
     * Get the Client for the Order.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
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


    /**
     * Get the Evacuator for the Order.
     */
    public function evacuator()
    {
        return $this->belongsTo(Evacuator::class);
    }


    /**
     * Get the Station for the Order.
     */
    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function bills()
    {
        $this->bills = $this->media()
                            ->where('media_type', 3)
                            ->get()
        ;
    }

    /**
     * Get the Media for the Order.
     */
    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function chatroom()
    {
        return $this->hasOne(Chatroom::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_order');
    }

    public function defectActInProcess()
    {
        return $this->hasOne(DefectActInProcess::class);
    }

    public function shownStatus()
    {
        return $this->belongsTo(Status::class, 'status');
    }

    public function checkPaid()
    {
        $parent    = Status::where('name', 'Ремонт выполнен')
                           ->first()->id;
        $status_id = Status::where('name', 'Оплата')
                           ->where('parent_id', $parent)
                           ->first()->id;

        if ($this->media()
                 ->where('media_type', 3)
                 ->whereNull('media.paid_at')
                 ->count() == 0) {
            $this->status_internal == 21;
            $this->save();

            event(new StatusChanged($status_id, $this->chatroom->id));

            return true;
        }

        return false;
    }
}
