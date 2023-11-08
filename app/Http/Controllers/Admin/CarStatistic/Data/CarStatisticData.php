<?php

namespace App\Http\Controllers\Admin\CarStatistic\Data;

use Spatie\LaravelData\Data;

final class CarStatisticData extends Data
{
    /**
     * @param string|null $carName
     * @param string|null $workName
     */
    public function __construct(

        public ?array $carName,
    ){}
}
