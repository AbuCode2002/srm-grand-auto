<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string  $name
 * @property string  $jur_address
 * @property string  $fact_address
 * @property string  $bin
 * @property string  $bik
 * @property string  $iik
 * @property string  $contact_person
 * @property string  $contact_phone
 * @property integer $region_id
 * @property integer $bank_id
 * @property integer $manager_id
 * @property string  $created_at
 * @property string  $updated_at
 * @property string  $deleted_at
 * @property Region  $region
 * @property Bank    $bank
 */
class Company extends Model
{
    use  SoftDeletes;

    static protected $columns = [
        'id'             => ['ork'],
        'name'           => ['ork'],
        'jur_address'    => ['ork'],
        'fact_address'   => ['ork'],
        'bin'            => ['ork'],
        'bik'            => ['ork'],
        'iik'            => ['ork'],
        'contact_person' => ['ork'],
        'contact_phone'  => ['ork'],
        'region'         => ['ork'],
        'created_at'     => ['ork'],
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'jur_address', 'fact_address', 'bin', 'bik', 'iik', 'contact_person', 'contact_phone', 'region_id', 'bank', 'bank_id', 'manager_id',
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
        'id'             => 'integer',
        'name'           => 'string',
        'jur_address'    => 'string',
        'bin'            => 'string',
        'bik'            => 'string',
        'iik'            => 'string',
        'contact_person' => 'string',
        'contact_phone'  => 'string',
        // 'created_at' => 'timestamp',
        // 'updated_at' => 'timestamp'
    ];

    /**
     * Get the Clients for the Company.
     */
    public function client()
    {
        return $this->hasOne(Client::class);
    }


    /**
     * Get the Cars for the Company.
     */
    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
