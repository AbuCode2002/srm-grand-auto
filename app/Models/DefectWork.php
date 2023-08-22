<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\DefectWork
 *
 * @property integer             $id
 * @property integer             $price
 * @property integer             $amount
 * @property \Carbon\Carbon      price_changed_at             ,
 * @property integer             $price_with_markup           ,
 * @property integer             $price_with_markup_updated_at,
 * @property \Carbon\Carbon      $applied_at                  ,
 * @property ?integer            $work_id                     ,
 * @property integer             $defect_act_id               ,
 * @property integer             $user_id                     ,
 * @property ?integer            $shop_id                     ,
 * @property boolean             $is_in_stock                 ,
 * @property \Carbon\Carbon      $rejected_at                 ,
 * @property string              $comment                     ,
 * @property string              $work_name
 * @property-read \App\DefectAct $defectAct
 */
class DefectWork extends Model
{
    use  SoftDeletes;

    protected $table = 'defect_act_work';
    protected $fillable = [
        'amount',
        'applied_at',
        'price',
        'price_with_markup',
        'price_with_markup_updated_at',
        'price_changed_at',
        'defect_act_id',
        'user_id',
        'work_id',
        'rejected_at',
        'comment',
        'station_comment',
        'work_name',
    ];

    public function defectAct()
    {
        return $this->belongsTo(DefectAct::class);
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
