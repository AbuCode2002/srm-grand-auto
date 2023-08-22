<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function children()
    {
        return $this->hasMany(Status::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Status::class, 'parent_id');
    }
}
