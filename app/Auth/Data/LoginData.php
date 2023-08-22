<?php

namespace App\Auth\Data;

use Spatie\LaravelData\Data;

class LoginData extends Data
{
    /**
     * @param string|null $email
     * @param string|null $password
     */
    public function __construct(
        public ?string $email,
        public ?string $password,
    )
    {
        //
    }
}
