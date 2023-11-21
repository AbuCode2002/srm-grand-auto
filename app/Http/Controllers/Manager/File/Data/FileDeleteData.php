<?php

namespace App\Http\Controllers\Manager\File\Data;

use Spatie\LaravelData\Data;

final class FileDeleteData extends Data
{
    /**
     * @param string|null $path
     */
    public function __construct(
        public ?string $result,
    ){}
}
