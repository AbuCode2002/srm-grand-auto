<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SparePart extends Model
{
    use HasFactory, SoftDeletes;

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function partNames(): BelongsTo
    {
        return $this->belongsTo(PartName::class, 'part_name_id', 'id');
    }
}
