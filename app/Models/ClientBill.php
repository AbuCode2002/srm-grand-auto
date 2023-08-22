<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientBill extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'bill_id';

    protected $fillable = ['defect_act_id', 'overal_price', 'bill_id', 'paid_at'];

    protected $casts = [
        'id'            => 'integer',
        'defect_act_id' => 'integer',
        'overal_price'  => 'float',
        'bill_id'       => 'string',
        'paid_at'       => 'timestamp',
    ];

    static public function canClose($bill_id)
    {
        $bills = Media
            ::query()
            ->where('media_type', 3)
            ->where('order_id', $bill_id)
            ->get()
        ;

        foreach ($bills as $bill) {
            if (is_null($bill->paid_at)) {
                return false;
            }
        }

        return true;
    }

    public function defectAct()
    {
        return $this->belongsTo(DefectAct::class);
    }
}
