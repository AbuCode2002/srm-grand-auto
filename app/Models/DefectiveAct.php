<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DefectiveAct extends Model
{
    use HasFactory, SoftDeletes;

    public function service()
    {
        return $this->hasMany(Service::class, 'service_id', 'id');
    }

    public function spareParts()
    {
        return $this->belongsTo(SparePart::class, 'spare_part_id', 'id');
    }
}
