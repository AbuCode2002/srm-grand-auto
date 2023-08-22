<?php

namespace App\Auth\Data;

use Spatie\LaravelData\Data;

class TelegramAccountData extends Data
{
    /**
     * @param int         $id
     * @param string      $hash
     * @param string|null $first_name
     * @param string|null $last_name
     * @param string|null $photo_url
     * @param string|null $username
     */
    public function __construct(
        public int $id,
        public string $hash,
        public ?string $first_name,
        public ?string $last_name,
        public ?string $photo_url,
        public ?string $username,
    ){}
}