<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    public function defectiveAct(): BelongsTo
    {
        return $this->belongsTo(DefectiveAct::class, 'defective_act_id', 'id');
    }
    public function sparePart(): HasMany
    {
        return $this->hasMany(SparePart::class, 'service_id', 'id');
    }

    public function serviceName(): BelongsTo
    {
        return $this->belongsTo(ServiceName::class, 'service_name_id', 'id');
    }
}
