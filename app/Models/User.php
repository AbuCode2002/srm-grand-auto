<?php

namespace App\Models;


use App\Auth\Data\TokenData;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Firebase\JWT\JWT;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property integer $id
 * @property string  $name
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role_id',
        'telegram_user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name'              => 'string',
        'email'             => 'string',
        'email_verified_at' => 'datetime',
        'password'          => 'string',
        'remember_token'    => 'string',
        'created_at'        => 'timestamp',
        'updated_at'        => 'timestamp',
    ];

    /**
     * Get the Clients for the User.
     */
    public function client()
    {
        return $this->hasOne(Client::class);
    }

    /**
     * Get the Role for the User.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function region()
    {
        return $this->hasMany(UserToRegion::class);
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class, UserToRegion::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'user_order');
    }

    public function jwt(): TokenData
    {
        $expiredAt    = now()->addSeconds(config('jwt-auth.ttl'));
        $issuedAtTime = now();

        $payload = array_merge($this->getJWTClaims(), [
            'iat' => $issuedAtTime->timestamp,
            'exp' => $expiredAt->timestamp,
        ]);

        return new TokenData(
            JWT::encode($payload, config('jwt-auth.secret'), config('jwt-auth.algo')),
            'bearer',
            $expiredAt
        );
    }

    public function getJWTClaims(): array
    {
        return [
            "id" => $this->id,
        ];
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
