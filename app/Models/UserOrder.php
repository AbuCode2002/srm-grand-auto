<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserOrder extends Pivot
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'order_id'];
}
