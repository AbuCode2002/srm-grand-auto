<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartName extends Model
{
    use HasFactory;

    public function category(): BelongsTo
    {
        return $this->belongsTo(PartCategory::class, 'category_id', 'id');
    }
}
