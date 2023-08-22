<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\DefectAct
 *
 * @property integer             $id
 * @property integer             $price
 * @property integer             $amount
 * @property \Carbon\Carbon      price_changed_at             ,
 * @property integer             $price_with_markup           ,
 * @property integer             $price_with_markup_updated_at,
 * @property \Carbon\Carbon      $applied_at                  ,
 * @property ?integer            $part_id                     ,
 * @property integer             $defect_act_id               ,
 * @property integer             $user_id                     ,
 * @property ?integer            $shop_id                     ,
 * @property boolean             $is_in_stock                 ,
 * @property \Carbon\Carbon      $rejected_at                 ,
 * @property string              $comment                     ,
 * @property string              $part_name
 * @property-read \App\DefectAct $defectAct
 * @property-read \App\Part      $part
 * @property-read \App\Shop      $shop
 */
class DefectPart extends Model
{
    use  SoftDeletes;

    protected $table = 'defect_act_part';

    protected $fillable = [
        'amount',
        'price',
        'price_changed_at',
        'price_with_markup',
        'price_with_markup_updated_at',
        'applied_at',
        'part_id',
        'defect_act_id',
        'user_id',
        'shop_id',
        'is_in_stock',
        'rejected_at',
        'comment',
        'part_name',
    ];

    public function defectAct(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DefectAct::class);
    }

    public function part(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Part::class);
    }

    public function shop(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
