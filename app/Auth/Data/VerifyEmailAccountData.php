<?php

namespace App\Auth\Data;

use Spatie\LaravelData\Data;

class VerifyEmailAccountData extends Data
{
    /**
     * @param string|null $code
     */
    public function __construct(
        public ?string $code,
    )
    {
        //
    }
}