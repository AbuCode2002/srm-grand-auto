<?php

namespace App\Auth\Data;

use Spatie\LaravelData\Data;

class RegisterData extends Data
{

    /**
     * @param string|null $email
     * @param string|null $name
     * @param string|null $password
     * @param string|null $role_id
     */
    public function __construct(
        public ?string $email,
        public ?string $name,
        public ?string $password,
        public ?string $role_id,
    )
    {
        //
    }
}
