<?php

namespace App\Http\Controllers\Admin\Station\Data;

use Spatie\LaravelData\Data;

final class StationData extends Data
{
    /**
     * @param int $region_id
     */
    public function __construct(
        public int $region_id,
    ){}
}
