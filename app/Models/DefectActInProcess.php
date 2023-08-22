<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefectActInProcess extends Model
{
    protected $fillable = [
        'user_id',
        'defect_act_id',
        'order_id',
        'approved',
    ];
}
