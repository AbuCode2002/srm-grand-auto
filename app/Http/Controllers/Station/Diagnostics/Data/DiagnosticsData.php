<?php

namespace App\Http\Controllers\Station\Diagnostics\Data;

use Spatie\LaravelData\Data;

final class DiagnosticsData extends Data
{
    /**
     * @param string|null $date
     * @param int|null $order_id
     */
    public function __construct(
        public ?string $date,
        public ?int $order_id,
    ){}
}
