<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Driver
 *
 * @property int     $id
 * @property string  $name
 * @property string  $phone
 * @property integer $company_id
 */
class Driver extends Model
{
    use  SoftDeletes;

    static protected $columns = [
        'phone' => ['ork'],
        'name'  => ['ork'],
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'phone', 'company_id',
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
        'phone'      => 'string',
        'name'       => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * Get the Orders for the Driver.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
