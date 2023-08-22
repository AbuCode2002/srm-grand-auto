<?php

namespace App\Auth\Data;

use Spatie\LaravelData\Data;

class SocialData extends Data
{
    /**
     * @param string|null $provider
     * @param string|null $token
     */
    public function __construct(
        public ?string $provider,
        public ?string $token,
    )
    {
        //
    }
}