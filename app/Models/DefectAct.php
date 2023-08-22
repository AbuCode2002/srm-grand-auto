<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\DefectAct
 *
 * @property integer                                                         $id
 * @property integer                                                         $order_id
 * @property-read \App\Order                                                 $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DefectPart[] $defectParts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DefectWork[] $defectWorks
 */
class DefectAct extends Model
{
    use  SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'order_id', 'paid_at', 'rejected_at', 'markup_percent',
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
        'paid'         => 'boolean',
        'paid_at'      => 'timestamp',
        'rejected'     => 'boolean',
        'rejected_at`' => 'string',
        'created_at'   => 'timestamp',
        'updated_at'   => 'timestamp',
    ];

    /**
     * Get the Order for the DefectAct.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the Parts for the DefectAct.
     */
    public function parts()
    {
        return $this->belongsToMany(Part::class);
    }

    public function defectParts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DefectPart::class);
    }

    public function defectWorks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DefectWork::class);
    }

    /**
     * Get the Works for the DefectAct.
     */
    public function works()
    {
        return $this->belongsToMany(Work::class);
    }
}
