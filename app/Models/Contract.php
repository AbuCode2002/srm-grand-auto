<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Contract
 *
 * @property int     $id
 * @property string  $number_of_contract
 * @property Carbon  $signed_at
 * @property Carbon  $expire_at
 * @property string  $manager_id
 * @property integer $budget
 */
class Contract extends Model
{
    static protected $columns = [
        'id'                 => ['ork'],
        'budget'             => ['ork'],
        'number_of_contract' => ['ork'],
        'signed_at'          => ['ork'],
        'expire_at'          => ['ork'],
    ];
    protected $fillable = ['id', 'company_id', 'manager_id', 'number_of_contract', 'budget', 'signed_at', 'expire_at', 'enabled'];
    protected $casts = [
        // 'signed_at' => 'timestamp',
        // 'expire_at' => 'timestamp'
    ];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function company() :BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function enable()
    {
        return $this->update(['enabled' => 1]);
    }

    public function disable()
    {
        return $this->update(['enabled' => 0]);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'company_id');
    }
}
