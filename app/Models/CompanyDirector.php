<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDirector extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
    ];
}
