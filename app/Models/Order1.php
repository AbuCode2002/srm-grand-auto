<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order1 extends Model
{
    use HasFactory;

    protected $table = 'orders1';

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_order');
    }

    public function defectActs(): HasOne
    {
        return $this->hasOne(DefectAct::class);
    }

    public function defectActInProcess()
    {
        return $this->hasOne(DefectActInProcess::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
