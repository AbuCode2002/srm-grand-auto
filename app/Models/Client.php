<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Client
 *
 * @property integer           $id
 * @property integer           $user_id
 * @property string            $name
 * @property-read \App\User    $user
 * @property-read \App\Company $company
 */
class Client extends Model
{
    use  SoftDeletes;

    static protected $columns = [
        'name'  => ['ork'],
        'phone' => ['ork'],
        'email' => ['ork'],
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'address', 'phone', 'email', 'company_id',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name'       => 'string',
        'address'    => 'string',
        'phone'      => 'string',
        'email'      => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * Get the Orders for the Client.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    /**
     * Get the User for the Client.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Get the Company for the Client.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
