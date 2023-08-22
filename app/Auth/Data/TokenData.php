<?php

namespace App\Auth\Data;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class TokenData extends Data
{
    /**
     * @param string|null $token
     * @param string|null $token_type
     * @param Carbon|null $expired_at
     */
    public function __construct(
        public ?string $token,
        public ?string $token_type,
        public ?Carbon $expired_at
    )
    {
        //
    }
}