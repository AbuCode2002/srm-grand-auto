<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evacuator extends Model
{
    use  SoftDeletes;

    static protected $columns = [
        'id'     => ['orpu'],
        'name'   => ['orpu'],
        'phone'  => ['orpu'],
        'region' => ['orpu'],
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'phone', 'region_id', 'region',
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
        'name'       => 'string',
        'phone'      => 'string',
        'region_id'  => 'integer',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * Get the Orders for the Evacuator.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
